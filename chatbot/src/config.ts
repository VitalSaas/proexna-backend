import dotenv from 'dotenv';

dotenv.config();

function env(key: string, fallback = ''): string {
  return process.env[key] ?? fallback;
}

export const config = {
  port: parseInt(env('PORT', '3030'), 10),
  anthropicApiKey: env('ANTHROPIC_API_KEY'),
  apiUrl: env('API_URL', 'http://localhost:8010'),
  chatwoot: {
    baseUrl: env('CHATWOOT_BASE_URL'),
    botToken: env('CHATWOOT_BOT_TOKEN'),
    accountId: env('CHATWOOT_ACCOUNT_ID'),
  },
  whatsappNumber: env('WHATSAPP_NUMBER'),
} as const;

export type Config = typeof config;
