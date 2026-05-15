import type {
  ChatwootWebhookPayload,
  AIResponse,
  ConversationContext,
  LeadScore,
} from './types.js';
import { conversationManager, type ManagedConversation } from './conversation-manager.js';
import { generateResponse } from './ai.js';
import {
  sendMessage,
  sendPrivateNote,
  assignToAgent,
  addLabel,
  removeLabel,
} from './chatwoot.js';
import { createProspect } from './api-client.js';

const LEAD_LABELS: Record<LeadScore, string> = {
  cold: 'lead-frio',
  warm: 'lead-tibio',
  hot: 'lead-caliente',
};

async function updateLeadScoreLabels(
  conversationId: number,
  newScore: LeadScore,
  oldScore?: LeadScore,
): Promise<void> {
  if (oldScore && oldScore !== newScore) {
    await removeLabel(conversationId, LEAD_LABELS[oldScore]).catch(() => {});
  }
  await addLabel(conversationId, LEAD_LABELS[newScore]).catch(() => {});
}

function buildAIContext(managed: ManagedConversation): ConversationContext {
  return {
    language: managed.language,
    conversationHistory: managed.conversationHistory,
    knownContact: {
      name: managed.contactName || null,
      phone: managed.contactPhone || null,
      email: managed.contactEmail || null,
    },
  };
}

export async function handleWebhook(payload: ChatwootWebhookPayload): Promise<void> {
  if (payload.event !== 'message_created') return;
  if (payload.message_type !== 'incoming') return;
  if (payload.sender?.type === 'user') return;

  const conversationId = payload.conversation?.id;
  if (!conversationId) {
    console.warn('[webhook] No conversation ID in payload, skipping.');
    return;
  }

  const content = payload.content?.trim();
  if (!content) return;

  try {
    const managed = conversationManager.getContext(conversationId);
    const previousScore = managed.leadScore;

    // Extract contact info from webhook payload
    const senderName = payload.sender?.name;
    const contactPhone =
      payload.contact?.phone_number ||
      (payload as any).conversation?.meta?.sender?.phone_number ||
      (payload as any).conversation?.contact_inbox?.contact?.phone_number;
    const contactEmail =
      payload.contact?.email ||
      (payload as any).conversation?.meta?.sender?.email;

    if (senderName && !managed.contactName) {
      conversationManager.updateContext(conversationId, { contactName: senderName });
    }
    if (contactPhone && !managed.contactPhone) {
      conversationManager.updateContext(conversationId, { contactPhone });
    }
    if (contactEmail && !managed.contactEmail) {
      conversationManager.updateContext(conversationId, { contactEmail });
    }

    conversationManager.addMessage(conversationId, 'user', content);

    const refreshedManaged = conversationManager.getContext(conversationId);
    const aiContext = buildAIContext(refreshedManaged);
    const aiResponse: AIResponse = await generateResponse(content, aiContext);

    if (aiResponse.detectedLanguage) {
      conversationManager.updateContext(conversationId, {
        language: aiResponse.detectedLanguage,
      });
    }

    if (aiResponse.leadScore) {
      conversationManager.updateContext(conversationId, {
        leadScore: aiResponse.leadScore,
      });
    }

    if (aiResponse.leadData) {
      conversationManager.updateContext(conversationId, {
        contactName: aiResponse.leadData.name || refreshedManaged.contactName,
        contactPhone: aiResponse.leadData.phone || refreshedManaged.contactPhone,
        contactEmail: aiResponse.leadData.email || refreshedManaged.contactEmail,
      });
    }

    if (aiResponse.message) {
      conversationManager.addMessage(conversationId, 'assistant', aiResponse.message);
    }

    switch (aiResponse.action) {
      case 'capture_lead':
      case 'handoff': {
        if (aiResponse.message) {
          await sendMessage(conversationId, aiResponse.message).catch((err) =>
            console.error('[webhook] sendMessage failed:', err?.message ?? err),
          );
        }

        const updatedManaged = conversationManager.getContext(conversationId);
        await persistProspect(conversationId, updatedManaged, aiResponse);

        const summary = buildLeadSummary(updatedManaged, conversationId, aiResponse);
        await sendPrivateNote(conversationId, summary).catch((err) =>
          console.error('[webhook] sendPrivateNote failed:', err?.message ?? err),
        );

        await addLabel(conversationId, 'lead-caliente').catch(() => {});
        await assignToAgent(conversationId).catch((err) =>
          console.error('[webhook] assignToAgent failed:', err?.message ?? err),
        );
        break;
      }

      case 'none':
      default: {
        if (aiResponse.message) {
          await sendMessage(conversationId, aiResponse.message).catch((err) =>
            console.error('[webhook] sendMessage failed:', err?.message ?? err),
          );
        }
        break;
      }
    }

    const finalManaged = conversationManager.getContext(conversationId);
    await updateLeadScoreLabels(conversationId, finalManaged.leadScore, previousScore);
  } catch (err) {
    console.error(`[webhook] Error processing conversation ${conversationId}:`, err);
  }
}

const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

function cleanString(value: string | null | undefined): string | null {
  if (!value) return null;
  const trimmed = String(value).trim();
  return trimmed.length > 0 ? trimmed : null;
}

function cleanEmail(value: string | null | undefined): string | null {
  const v = cleanString(value);
  return v && EMAIL_RE.test(v) ? v : null;
}

function normalizeServiceDate(value: string | null | undefined): string | null {
  const v = cleanString(value);
  if (!v) return null;
  const date = new Date(v);
  if (Number.isNaN(date.getTime())) return null;
  return date.toISOString().slice(0, 19).replace('T', ' ');
}

async function persistProspect(
  conversationId: number,
  ctx: ManagedConversation,
  aiResponse: AIResponse,
): Promise<void> {
  if (ctx.prospectId) return;

  const lead = aiResponse.leadData;
  const name = cleanString(lead?.name) ?? cleanString(ctx.contactName);
  const phone = cleanString(lead?.phone) ?? cleanString(ctx.contactPhone);
  const email = cleanEmail(lead?.email) ?? cleanEmail(ctx.contactEmail);

  if (!name || (!phone && !email)) {
    console.warn(
      `[webhook] Skipping prospect persist for conversation ${conversationId}: missing name or contact.`,
    );
    return;
  }

  const interestParts = [
    cleanString(lead?.service_interest),
    cleanString(lead?.location),
    cleanString(lead?.notes),
  ].filter((v): v is string => Boolean(v));

  const tentativeServiceDate = normalizeServiceDate(lead?.tentative_service_date);

  try {
    const prospect = await createProspect({
      name,
      email,
      phone,
      interest: interestParts.length ? interestParts.join(' — ') : null,
      tentative_service_date: tentativeServiceDate,
      source: 'chatbot',
      chatbot_conversation_id: String(conversationId),
      chatbot_payload: {
        leadScore: ctx.leadScore,
        language: ctx.language,
        action: aiResponse.action,
        service_interest: cleanString(lead?.service_interest),
        location: cleanString(lead?.location),
        notes: cleanString(lead?.notes),
        tentative_service_date_raw: cleanString(lead?.tentative_service_date),
      },
    });
    conversationManager.updateContext(conversationId, { prospectId: prospect.id });
    console.log(
      `[webhook] Prospect #${prospect.id} created for conversation ${conversationId}.`,
    );
  } catch (err: any) {
    console.error(
      `[webhook] createProspect failed for conversation ${conversationId}:`,
      err?.response?.data ?? err?.message ?? err,
    );
  }
}

function buildLeadSummary(
  ctx: ManagedConversation,
  conversationId: number,
  aiResponse: AIResponse,
): string {
  const lead = aiResponse.leadData;
  const lines = [
    '--- Resumen del Lead (Bot IA) ---',
    `Conversación: #${conversationId}`,
    `Nombre: ${lead?.name ?? ctx.contactName ?? 'No proporcionado'}`,
    `Teléfono: ${lead?.phone ?? ctx.contactPhone ?? 'No proporcionado'}`,
    `Email: ${lead?.email ?? ctx.contactEmail ?? 'No proporcionado'}`,
    `Fecha tentativa: ${lead?.tentative_service_date ?? 'No proporcionada'}`,
    `Servicio de interés: ${lead?.service_interest ?? 'No identificado'}`,
    `Ubicación: ${lead?.location ?? 'No identificada'}`,
    `Idioma: ${ctx.language === 'es' ? 'Español' : 'English'}`,
    `Puntuación: ${ctx.leadScore}`,
    lead?.notes ? `Notas: ${lead.notes}` : '',
    '',
    'Últimos mensajes:',
    ...ctx.conversationHistory.slice(-6).map(
      (m) => `  [${m.role}]: ${m.content.substring(0, 200)}`,
    ),
    '--- Fin del resumen ---',
  ].filter(Boolean);

  return lines.join('\n');
}
