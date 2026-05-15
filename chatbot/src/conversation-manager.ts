import type { ConversationMessage, LeadScore } from './types.js';

const MAX_HISTORY_LENGTH = 20;
const INACTIVE_TIMEOUT_MS = 24 * 60 * 60 * 1000; // 24 hours

/**
 * Per-conversation state tracked by the bot. This is separate from the
 * `ConversationContext` type used by the AI module — we build that on
 * the fly from this state before each AI call.
 */
export interface ManagedConversation {
  language: 'es' | 'en';
  conversationHistory: ConversationMessage[];
  leadScore: LeadScore;
  contactName: string | undefined;
  contactPhone: string | undefined;
  contactEmail: string | undefined;
  prospectId: number | undefined;
  lastActivity: Date;
}

export class ConversationManager {
  private conversations: Map<number, ManagedConversation> = new Map();
  private cleanupTimer: ReturnType<typeof setInterval>;

  constructor() {
    // Run cleanup every hour
    this.cleanupTimer = setInterval(() => this.cleanup(), 60 * 60 * 1000);
  }

  /**
   * Get conversation state, creating a fresh one if it doesn't exist.
   */
  getContext(conversationId: number): ManagedConversation {
    let ctx = this.conversations.get(conversationId);

    if (!ctx) {
      ctx = {
        language: 'es',
        conversationHistory: [],
        leadScore: 'cold',
        contactName: undefined,
        contactPhone: undefined,
        contactEmail: undefined,
        prospectId: undefined,
        lastActivity: new Date(),
      };
      this.conversations.set(conversationId, ctx);
    }

    return ctx;
  }

  /**
   * Partially update a conversation's state.
   */
  updateContext(
    conversationId: number,
    update: Partial<ManagedConversation>,
  ): void {
    const ctx = this.getContext(conversationId);
    Object.assign(ctx, update, { lastActivity: new Date() });
  }

  /**
   * Append a message to the conversation history. Keeps only the last
   * MAX_HISTORY_LENGTH messages to stay within the AI context window.
   */
  addMessage(
    conversationId: number,
    role: 'user' | 'assistant',
    content: string,
  ): void {
    const ctx = this.getContext(conversationId);
    ctx.conversationHistory.push({ role, content });

    if (ctx.conversationHistory.length > MAX_HISTORY_LENGTH) {
      ctx.conversationHistory = ctx.conversationHistory.slice(
        -MAX_HISTORY_LENGTH,
      );
    }

    ctx.lastActivity = new Date();
  }

  /**
   * Clear a conversation's state entirely.
   */
  clearContext(conversationId: number): void {
    this.conversations.delete(conversationId);
  }

  /**
   * Remove conversations that have been inactive for more than 24 hours.
   */
  private cleanup(): void {
    const now = Date.now();

    for (const [id, ctx] of this.conversations) {
      if (now - ctx.lastActivity.getTime() > INACTIVE_TIMEOUT_MS) {
        this.conversations.delete(id);
      }
    }
  }

  /**
   * Stop the cleanup timer (for graceful shutdown).
   */
  destroy(): void {
    clearInterval(this.cleanupTimer);
  }
}

// Singleton instance
export const conversationManager = new ConversationManager();
