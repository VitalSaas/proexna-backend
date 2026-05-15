// ---------------------------------------------------------------------------
// Shared TypeScript types for Proexna Chatbot
// ---------------------------------------------------------------------------

// ---- Laravel API response types ------------------------------------------

export interface Project {
  slug: string;
  title: string;
  short_description: string | null;
  client: string | null;
  location: string | null;
  category: string | null;
  completed_at: string | null;
  featured: boolean;
  url: string;
}

export interface Sector {
  title: string;
  description: string | null;
}

export interface Testimonial {
  name: string;
  role: string | null;
  company: string | null;
  quote: string;
  rating: number | null;
}

export interface Vacancy {
  slug: string;
  title: string;
  department: string | null;
  location: string | null;
  employment_type: string | null;
  salary_range: string | null;
  short_description: string | null;
  closes_at: string | null;
  url: string;
}

export interface StatItem {
  value: string;
  label: string;
}

export interface WhyChooseUsItem {
  title: string;
  description: string | null;
}

export interface Post {
  slug: string;
  title: string;
  excerpt: string | null;
  category: string | null;
  published_at: string | null;
  url: string;
}

export interface ProspectPayload {
  name: string;
  email?: string | null;
  phone?: string | null;
  company?: string | null;
  interest?: string | null;
  budget_range?: string | null;
  tentative_service_date?: string | null;
  source?: string;
  chatbot_conversation_id?: string;
  chatbot_payload?: Record<string, unknown>;
}

export interface ProspectResponse {
  id: number;
  status: string;
  created_at: string;
}

export interface CompanyInfo {
  name: string;
  tagline: string;
  phone: string;
  phone_display: string;
  whatsapp: string;
  email: string;
  website: string;
  welcome: {
    title: string;
    content: string;
  } | null;
}

// ---- Chatbot domain types ------------------------------------------------

export type LeadScore = 'cold' | 'warm' | 'hot';

export interface ConversationMessage {
  role: 'user' | 'assistant';
  content: string;
}

export interface ConversationContext {
  language: 'es' | 'en';
  conversationHistory: ConversationMessage[];
  knownContact?: {
    name: string | null;
    phone: string | null;
    email: string | null;
  };
}

export interface LeadData {
  name: string;
  phone: string;
  email?: string;
  tentative_service_date?: string;
  service_interest?: string;
  location?: string;
  notes?: string;
}

export interface AIResponse {
  message: string;
  action?: 'handoff' | 'capture_lead' | 'none';
  leadScore?: LeadScore;
  leadData?: LeadData;
  detectedLanguage?: 'es' | 'en';
}

// ---- Chatwoot webhook types ----------------------------------------------

export interface ChatwootContact {
  id: number;
  name: string;
  phone_number: string | null;
  email: string | null;
}

export interface ChatwootConversation {
  id: number;
  account_id: number;
  inbox_id: number;
  status: string;
  contact_last_seen_at: string | null;
}

export interface ChatwootSender {
  id: number;
  name: string;
  type: 'contact' | 'user';
}

export interface ChatwootMessage {
  id: number;
  content: string;
  message_type: 'incoming' | 'outgoing' | 'activity';
  content_type: string;
  created_at: string;
  conversation_id: number;
  sender?: ChatwootSender;
}

export interface ChatwootWebhookPayload {
  event: string;
  id?: number;
  content?: string;
  message_type?: 'incoming' | 'outgoing' | 'activity';
  content_type?: string;
  created_at?: string;
  conversation?: ChatwootConversation;
  sender?: ChatwootSender;
  contact?: ChatwootContact;
  account?: { id: number };
}
