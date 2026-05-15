import Anthropic from '@anthropic-ai/sdk';
import { config } from './config.js';
import { detectLanguage } from './language.js';
import { scoreLead } from './lead-scoring.js';
import {
  getProjects,
  getSectors,
  getTestimonials,
  getVacancies,
  getStats,
  getWhyChooseUs,
  getCompany,
} from './api-client.js';
import type {
  Project,
  Sector,
  Testimonial,
  Vacancy,
  StatItem,
  WhyChooseUsItem,
  CompanyInfo,
  ConversationContext,
  AIResponse,
  LeadData,
} from './types.js';

const anthropic = new Anthropic({ apiKey: config.anthropicApiKey });

// ---------------------------------------------------------------------------
// In-memory catalog cache (refreshed every 10 min)
// ---------------------------------------------------------------------------

interface Catalog {
  company: CompanyInfo | null;
  projects: Project[];
  sectors: Sector[];
  testimonials: Testimonial[];
  vacancies: Vacancy[];
  stats: StatItem[];
  whyChooseUs: WhyChooseUsItem[];
}

let catalog: Catalog = {
  company: null,
  projects: [],
  sectors: [],
  testimonials: [],
  vacancies: [],
  stats: [],
  whyChooseUs: [],
};
let cacheTimestamp = 0;
const CACHE_TTL = 10 * 60 * 1000;

export async function refreshCatalog(force = false): Promise<void> {
  if (!force && Date.now() - cacheTimestamp < CACHE_TTL && catalog.company) return;

  const [company, projects, sectors, testimonials, vacancies, stats, whyChooseUs] =
    await Promise.all([
      getCompany().catch(() => null),
      getProjects().catch(() => []),
      getSectors().catch(() => []),
      getTestimonials().catch(() => []),
      getVacancies().catch(() => []),
      getStats().catch(() => []),
      getWhyChooseUs().catch(() => []),
    ]);

  catalog = { company, projects, sectors, testimonials, vacancies, stats, whyChooseUs };
  cacheTimestamp = Date.now();
  console.log(
    `[ai] Catalog refreshed: ${projects.length} projects, ${sectors.length} sectors, ${vacancies.length} vacancies, ${testimonials.length} testimonials`,
  );
}

export function getCatalog(): Catalog {
  return catalog;
}

// ---------------------------------------------------------------------------
// System prompt builder
// ---------------------------------------------------------------------------

function buildSystemPrompt(ctx: ConversationContext): string {
  const c = catalog.company;
  const companyBlock = c
    ? `Empresa: ${c.name} — ${c.tagline}
Teléfono: ${c.phone_display} (WhatsApp: ${c.whatsapp})
Email: ${c.email}
Sitio: ${c.website}
${c.welcome ? `\nSobre nosotros:\n${c.welcome.content}` : ''}`
    : 'Empresa: PROEXNA — Servicios profesionales de jardinería y paisajismo en Oaxaca';

  const sectorsBlock = catalog.sectors.length
    ? catalog.sectors.map((s) => `- ${s.title}: ${s.description ?? ''}`).join('\n')
    : '(sin sectores configurados)';

  const whyBlock = catalog.whyChooseUs.length
    ? catalog.whyChooseUs.map((w) => `- ${w.title}: ${w.description ?? ''}`).join('\n')
    : '';

  const projectsBlock = catalog.projects.length
    ? catalog.projects
        .slice(0, 15)
        .map(
          (p) =>
            `- "${p.title}"${p.client ? ` (cliente: ${p.client})` : ''}${p.location ? ` — ${p.location}` : ''}${p.category ? ` — ${p.category}` : ''}. ${p.short_description ?? ''} URL: ${p.url}`,
        )
        .join('\n')
    : '(sin proyectos cargados)';

  const vacanciesBlock = catalog.vacancies.length
    ? catalog.vacancies
        .map(
          (v) =>
            `- "${v.title}"${v.department ? ` (${v.department})` : ''}${v.location ? ` — ${v.location}` : ''}${v.employment_type ? ` — ${v.employment_type}` : ''}. ${v.short_description ?? ''} URL: ${v.url}`,
        )
        .join('\n')
    : '(no hay vacantes abiertas en este momento)';

  const testimonialsBlock = catalog.testimonials.length
    ? catalog.testimonials
        .slice(0, 5)
        .map((t) => `- ${t.name}${t.company ? ` (${t.company})` : ''}: "${t.quote}"`)
        .join('\n')
    : '';

  const statsBlock = catalog.stats.length
    ? catalog.stats.map((s) => `${s.value} ${s.label}`).join(' · ')
    : '';

  const known = ctx.knownContact;
  const knownBlock = known
    ? `Datos del cliente ya conocidos (NO los vuelvas a pedir):
- Nombre: ${known.name ?? 'desconocido'}
- Teléfono: ${known.phone ?? 'desconocido'}
- Email: ${known.email ?? 'desconocido'}`
    : '';

  const langInstruction =
    ctx.language === 'en'
      ? 'IMPORTANT: Respond in English. Use a warm, professional tone.'
      : 'IMPORTANTE: Responde en español mexicano. Tono cálido, profesional y cercano.';

  return `Eres el asistente virtual oficial de PROEXNA, empresa oaxaqueña especializada en jardinería profesional, paisajismo, diseño de jardines, mantenimiento, instalación y tratamiento de áreas verdes.

${langInstruction}

═══ INFORMACIÓN DE LA EMPRESA ═══
${companyBlock}
${statsBlock ? `\nNuestros números: ${statsBlock}` : ''}

═══ SECTORES QUE ATENDEMOS ═══
${sectorsBlock}

${whyBlock ? `═══ POR QUÉ ELEGIRNOS ═══\n${whyBlock}\n` : ''}
═══ PROYECTOS DESTACADOS ═══
${projectsBlock}

═══ VACANTES ABIERTAS ═══
${vacanciesBlock}

${testimonialsBlock ? `═══ TESTIMONIOS DE CLIENTES ═══\n${testimonialsBlock}\n` : ''}
${knownBlock}

═══ TUS OBJETIVOS ═══
1. Resolver dudas sobre nuestros servicios (diseño, paisajismo, mantenimiento, instalación, tratamiento)
2. Mostrar proyectos relevantes según lo que pregunte el cliente
3. Captar leads: cuando un cliente muestre interés genuino en cotizar o agendar visita, pide en este orden:
   a) NOMBRE completo
   b) TELÉFONO de contacto (preferentemente WhatsApp)
   c) CORREO electrónico
   d) FECHA TENTATIVA de visita o servicio (puede ser un día, rango o "lo antes posible")
   e) Descripción breve de lo que necesita (ubicación, tipo de espacio, alcance)
4. Si pregunta por empleo, dirígelo a las vacantes abiertas y al portal /carreras
5. Si pregunta algo fuera del alcance (legal, técnico complejo, urgencias), ofrece transferirlo con un asesor humano

═══ REGLAS ═══
- Nunca inventes precios concretos. Las cotizaciones son personalizadas: pide datos y promete que un asesor le contactará con propuesta formal.
- Nunca inventes proyectos, testimonios o vacantes que no estén en las listas de arriba.
- Sé conciso (2-4 párrafos cortos máximo). Usa viñetas si listas opciones.
- Pide los datos UNO O DOS A LA VEZ, no todos juntos en una sola pregunta (mejor experiencia conversacional).
- Si el cliente ya dio algún dato, NO lo vuelvas a pedir.
- Cuando tengas los 4 datos (nombre, teléfono, correo, fecha tentativa) confirma con el cliente y marca capture_lead.
- Para emojis: usa 🌱 con moderación, solo al saludar o en momentos cálidos.

═══ FORMATO DE RESPUESTA ═══
Responde SIEMPRE en JSON válido con esta estructura exacta:
{
  "message": "El mensaje que verá el cliente en la conversación",
  "action": "none" | "capture_lead" | "handoff",
  "leadScore": "cold" | "warm" | "hot",
  "leadData": { "name": "...", "phone": "...", "email": "...", "tentative_service_date": "...", "service_interest": "...", "location": "...", "notes": "..." }
}

- "action": "capture_lead" → cuando ya tienes nombre + teléfono + correo + fecha tentativa. Incluye leadData completo.
- "action": "handoff" → cuando el cliente pide hablar con humano o el caso es complejo.
- "action": "none" → conversación normal de información o todavía recolectando datos.
- "leadScore": "cold" = solo info general; "warm" = preguntó por servicios específicos, ubicación, alcance; "hot" = ya dio datos personales o pidió cotización formal.
- leadData: inclúyelo apenas tengas cualquier dato (aunque sea parcial), para que se actualice progresivamente. En capture_lead debe tener todos los campos requeridos.
- tentative_service_date: usa formato ISO 8601 "YYYY-MM-DD" o "YYYY-MM-DD HH:mm" cuando el cliente especifique día/hora. Si dice "lo antes posible" o algo genérico, omite el campo y refleja eso en notes.
`;
}

// ---------------------------------------------------------------------------
// Main response generator
// ---------------------------------------------------------------------------

export async function generateResponse(
  userMessage: string,
  ctx: ConversationContext,
): Promise<AIResponse> {
  await refreshCatalog().catch((err) => console.error('[ai] Catalog refresh failed:', err));

  const detectedLanguage = detectLanguage(userMessage);
  const effectiveCtx: ConversationContext = { ...ctx, language: detectedLanguage };

  const systemPrompt = buildSystemPrompt(effectiveCtx);

  const messages = [
    ...ctx.conversationHistory.slice(-12).map((m) => ({
      role: m.role,
      content: m.content,
    })),
    { role: 'user' as const, content: userMessage },
  ];

  try {
    const response = await anthropic.messages.create({
      model: 'claude-haiku-4-5-20251001',
      max_tokens: 1024,
      system: systemPrompt,
      messages,
    });

    const textBlock = response.content.find((b) => b.type === 'text');
    const raw = textBlock && 'text' in textBlock ? textBlock.text : '';

    const parsed = parseAIResponse(raw);
    const heuristicScore = scoreLead([...ctx.conversationHistory, { role: 'user', content: userMessage }]);

    return {
      message: parsed.message || raw,
      action: parsed.action ?? 'none',
      leadScore: parsed.leadScore ?? heuristicScore,
      leadData: parsed.leadData,
      detectedLanguage,
    };
  } catch (err) {
    console.error('[ai] Claude call failed:', err);
    return {
      message:
        detectedLanguage === 'en'
          ? 'Sorry, I had a problem responding. An advisor will assist you shortly.'
          : 'Lo siento, tuve un problema para responder. Un asesor te contactará en breve.',
      action: 'handoff',
      leadScore: 'warm',
      detectedLanguage,
    };
  }
}

function parseAIResponse(raw: string): Partial<AIResponse> & { leadData?: LeadData } {
  if (!raw) return {};

  // Strip markdown code fences if present
  const cleaned = raw
    .trim()
    .replace(/^```(?:json)?\s*/i, '')
    .replace(/\s*```$/, '');

  // Try direct JSON parse
  try {
    return JSON.parse(cleaned);
  } catch {
    // Fall back to extracting the first {...} block
    const match = cleaned.match(/\{[\s\S]*\}/);
    if (match) {
      try {
        return JSON.parse(match[0]);
      } catch {
        /* ignore */
      }
    }
  }

  // If we got plain text instead of JSON, wrap it
  return { message: cleaned };
}
