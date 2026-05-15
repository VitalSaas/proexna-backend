import axios, { type AxiosInstance } from 'axios';
import { config } from './config.js';

let client: AxiosInstance;

function getClient(): AxiosInstance {
  if (!client) {
    client = axios.create({
      baseURL: `${config.chatwoot.baseUrl}/api/v1/accounts/${config.chatwoot.accountId}`,
      headers: {
        'Content-Type': 'application/json',
        'api-access-token': config.chatwoot.botToken,
      },
      timeout: 10_000,
    });
  }
  return client;
}

/**
 * Send a text message to a Chatwoot conversation (as the bot).
 */
export async function sendMessage(
  conversationId: number,
  content: string,
): Promise<void> {
  await getClient().post(
    `/conversations/${conversationId}/messages`,
    {
      content,
      message_type: 'outgoing',
    },
  );
}

/**
 * Send a private note visible only to human agents.
 */
export async function sendPrivateNote(
  conversationId: number,
  content: string,
): Promise<void> {
  await getClient().post(
    `/conversations/${conversationId}/messages`,
    {
      content,
      message_type: 'outgoing',
      private: true,
    },
  );
}

/**
 * Hand off the conversation to a human agent.
 * 1. Toggle the bot off for this conversation
 * 2. Set status to 'open' so it appears in the agent's panel
 * 3. Try to assign to the first available agent in the inbox
 */
export async function assignToAgent(conversationId: number): Promise<void> {
  const c = getClient();

  // Set conversation status to open
  await c.post(`/conversations/${conversationId}/toggle_status`, {
    status: 'open',
  });

  // Try to get inbox members (agents) and assign the first one
  try {
    const { data: convData } = await c.get(`/conversations/${conversationId}`);
    const inboxId = convData?.inbox_id;

    if (inboxId) {
      const { data: inboxData } = await c.get(`/inbox_members/${inboxId}`);
      const agents = inboxData?.payload || inboxData || [];

      if (Array.isArray(agents) && agents.length > 0) {
        const agentId = agents[0]?.id || agents[0]?.user_id;
        if (agentId) {
          await c.post(`/conversations/${conversationId}/assignments`, {
            assignee_id: agentId,
          });
          return;
        }
      }
    }
  } catch {
    // If we can't find agents, just un-assign the bot
  }

  // Fallback: un-assign bot, Chatwoot will show it as unassigned/open
  await c.post(`/conversations/${conversationId}/assignments`, {
    assignee_id: 0,
  });
}

/**
 * Add a label to a conversation.
 */
export async function addLabel(
  conversationId: number,
  label: string,
): Promise<void> {
  // Chatwoot expects the full list of labels; we need to fetch current ones first.
  const { data } = await getClient().get<{ payload: { labels: string[] } }>(
    `/conversations/${conversationId}`,
  );
  const currentLabels: string[] = data?.payload?.labels ?? [];

  if (!currentLabels.includes(label)) {
    await getClient().post(
      `/conversations/${conversationId}/labels`,
      {
        labels: [...currentLabels, label],
      },
    );
  }
}

/**
 * Remove a label from a conversation.
 */
export async function removeLabel(
  conversationId: number,
  label: string,
): Promise<void> {
  const { data } = await getClient().get<{ payload: { labels: string[] } }>(
    `/conversations/${conversationId}`,
  );
  const currentLabels: string[] = data?.payload?.labels ?? [];

  if (currentLabels.includes(label)) {
    await getClient().post(
      `/conversations/${conversationId}/labels`,
      {
        labels: currentLabels.filter((l) => l !== label),
      },
    );
  }
}

/**
 * Get contact information by contact ID.
 */
export async function getContact(
  contactId: number,
): Promise<Record<string, unknown>> {
  const { data } = await getClient().get(`/contacts/${contactId}`);
  return data;
}

/**
 * Update contact information.
 */
export async function updateContact(
  contactId: number,
  updateData: Record<string, unknown>,
): Promise<Record<string, unknown>> {
  const { data } = await getClient().put(
    `/contacts/${contactId}`,
    updateData,
  );
  return data;
}
