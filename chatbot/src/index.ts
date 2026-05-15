import 'dotenv/config';
import express from 'express';
import { config } from './config.js';
import { refreshCatalog, getCatalog } from './ai.js';
import { handleWebhook } from './webhook-handler.js';
import type { ChatwootWebhookPayload } from './types.js';

const app = express();

app.use(express.json());

// ---- Routes -------------------------------------------------------------

/**
 * POST /webhook/chatwoot
 * Receives Chatwoot webhook events.
 */
app.post('/webhook/chatwoot', async (req, res) => {
  const payload = req.body as ChatwootWebhookPayload;

  console.log(
    `[server] Webhook received: event=${payload.event} type=${payload.message_type} content="${(payload.content || '').substring(0, 50)}"`,
  );

  res.status(200).json({ status: 'ok' });

  handleWebhook(payload).catch((err) => {
    console.error('[server] Unhandled error in webhook handler:', err);
  });
});

/**
 * GET /health
 */
app.get('/health', (_req, res) => {
  const c = getCatalog();
  res.status(200).json({
    status: 'healthy',
    uptime: process.uptime(),
    catalog: {
      company: c.company?.name ?? null,
      projects: c.projects.length,
      sectors: c.sectors.length,
      vacancies: c.vacancies.length,
      testimonials: c.testimonials.length,
    },
  });
});

// ---- Startup ------------------------------------------------------------

async function start(): Promise<void> {
  console.log('[server] Starting Proexna Chatbot...');

  try {
    await refreshCatalog(true);
  } catch (err) {
    console.error('[server] Initial catalog refresh failed (continuing anyway):', err);
  }

  // Refresh catalog every 10 minutes
  setInterval(() => {
    refreshCatalog(true).catch((err) =>
      console.error('[server] Scheduled catalog refresh failed:', err),
    );
  }, 10 * 60 * 1000);

  const port = config.port;
  app.listen(port, () => {
    console.log(`[server] Listening on port ${port}`);
    console.log(`[server] Webhook URL: POST http://localhost:${port}/webhook/chatwoot`);
    console.log(`[server] Health check: GET http://localhost:${port}/health`);
  });
}

start().catch((err) => {
  console.error('[server] Fatal startup error:', err);
  process.exit(1);
});
