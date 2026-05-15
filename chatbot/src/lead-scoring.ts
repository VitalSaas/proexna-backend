import type { ConversationMessage, LeadScore } from './types.js';

const HOT_PATTERNS = [
  /\bmi nombre\b/i,
  /\bme llamo\b/i,
  /\bmy name\b/i,
  /\bcotiza/i,
  /\bquote\b/i,
  /\bpresupuest/i,
  /\bcontrat/i,
  /\bhire\b/i,
  /\b\+?52\s?9?\d{2}\s?\d{3}\s?\d{4}/, // Mexican phone
  /\b\d{10,}\b/,                        // any 10+ digit number
  /\b[\w.+-]+@[\w-]+\.\w+/,             // email
];

const WARM_PATTERNS = [
  /\bprecio\b/i,
  /\bcost/i,
  /\bcu[áa]nto\b/i,
  /\bhow much/i,
  /\bjard[íi]n/i,
  /\bjardin/i,
  /\bgarden/i,
  /\bpaisaj/i,
  /\blandscap/i,
  /\bmantenimiento\b/i,
  /\bmaintenance\b/i,
  /\bdise[ñn]o\b/i,
  /\bdesign\b/i,
  /\binstalaci[óo]n\b/i,
  /\briego\b/i,
  /\birrigation\b/i,
  /\bpoda\b/i,
  /\b[áa]rbol/i,
  /\btree\b/i,
  /\bcésped\b/i,
  /\bcesped\b/i,
  /\blawn\b/i,
  /\bresidencial\b/i,
  /\bcomercial\b/i,
  /\bhotelero\b/i,
  /\bcorporativ/i,
  /\binstitucional\b/i,
];

function matchCount(text: string, patterns: RegExp[]): number {
  return patterns.reduce((n, re) => n + (re.test(text) ? 1 : 0), 0);
}

/**
 * Score the lead based on the whole conversation:
 *  - hot:  customer gave personal data (name + phone/email) or asked for a formal quote
 *  - warm: customer asked about specific services, locations or pricing
 *  - cold: general browsing / first contact
 */
export function scoreLead(conversationHistory: ConversationMessage[]): LeadScore {
  const userText = conversationHistory
    .filter((m) => m.role === 'user')
    .map((m) => m.content)
    .join(' ');

  const hotHits = matchCount(userText, HOT_PATTERNS);
  if (hotHits >= 2) return 'hot';

  const warmHits = matchCount(userText, WARM_PATTERNS);
  if (hotHits >= 1 || warmHits >= 2) return 'warm';

  return 'cold';
}
