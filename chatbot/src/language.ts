// ---------------------------------------------------------------------------
// Simple keyword-based language detection (no external API)
// ---------------------------------------------------------------------------

const ENGLISH_KEYWORDS = new Set([
  'hello', 'hi', 'hey', 'good', 'morning', 'afternoon', 'evening',
  'how', 'much', 'what', 'when', 'where', 'which', 'who', 'why',
  'the', 'is', 'are', 'was', 'were', 'have', 'has', 'had',
  'can', 'could', 'would', 'should', 'will', 'shall',
  'this', 'that', 'these', 'those', 'there', 'here',
  'price', 'cost', 'quote', 'available', 'information',
  'please', 'thank', 'thanks', 'yes', 'no', 'okay',
  'want', 'need', 'looking', 'interested', 'help',
  'garden', 'gardening', 'landscape', 'landscaping',
  'design', 'maintenance', 'lawn', 'trees', 'plants',
  'residential', 'commercial', 'hotel', 'corporate',
]);

/**
 * Detect whether `text` is in English or Spanish.
 */
export function detectLanguage(text: string): 'es' | 'en' {
  const words = text
    .toLowerCase()
    .replace(/[^a-záéíóúñü\s]/g, '')
    .split(/\s+/)
    .filter(Boolean);

  if (words.length === 0) return 'es';

  let englishHits = 0;
  for (const word of words) {
    if (ENGLISH_KEYWORDS.has(word)) {
      englishHits++;
    }
  }

  return englishHits / words.length >= 0.3 ? 'en' : 'es';
}
