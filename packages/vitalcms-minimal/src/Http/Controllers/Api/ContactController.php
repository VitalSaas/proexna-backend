<?php

namespace VitalSaaS\VitalCMSMinimal\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use VitalSaaS\VitalCMSMinimal\Models\CmsContactSubmission;

class ContactController extends Controller
{
    /**
     * Store a new contact form submission.
     */
    public function store(Request $request): JsonResponse
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
            'service_interest' => 'nullable|string|in:' . implode(',', array_keys(CmsContactSubmission::getServiceInterests())),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Create the contact submission
            $submission = CmsContactSubmission::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject ?? 'Contacto desde sitio web',
                'message' => $request->message,
                'service_interest' => $request->service_interest,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => CmsContactSubmission::STATUS_NEW,
            ]);

            // Send email notification if enabled
            if (config('vitalcms.contact.email_notifications', true)) {
                $this->sendEmailNotification($submission);
            }

            // Send auto-reply if enabled
            if (config('vitalcms.contact.auto_reply', true)) {
                $this->sendAutoReply($submission);
            }

            return response()->json([
                'success' => true,
                'message' => '¡Gracias por contactarnos! Te responderemos pronto.',
                'data' => [
                    'id' => $submission->id,
                    'reference' => 'PROEXNA-' . str_pad($submission->id, 6, '0', STR_PAD_LEFT),
                    'status' => $submission->status,
                ],
            ], 201);

        } catch (\Exception $e) {
            Log::error('Contact form submission failed', [
                'error' => $e->getMessage(),
                'data' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el formulario. Por favor intenta nuevamente.',
                'debug' => app()->environment('local') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get contact submissions (for authenticated users only).
     */
    public function index(Request $request): JsonResponse
    {
        $query = CmsContactSubmission::query()
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('service_interest')) {
            $query->where('service_interest', $request->service_interest);
        }

        if ($request->boolean('unread')) {
            $query->whereNull('read_at');
        }

        // Pagination
        $perPage = min($request->get('per_page', 15), 100);
        $submissions = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $submissions->items(),
            'meta' => [
                'current_page' => $submissions->currentPage(),
                'per_page' => $submissions->perPage(),
                'total' => $submissions->total(),
                'last_page' => $submissions->lastPage(),
            ],
            'stats' => [
                'total_submissions' => CmsContactSubmission::count(),
                'new_submissions' => CmsContactSubmission::where('status', CmsContactSubmission::STATUS_NEW)->count(),
                'unread_submissions' => CmsContactSubmission::whereNull('read_at')->count(),
                'today_submissions' => CmsContactSubmission::whereDate('created_at', today())->count(),
            ]
        ]);
    }

    /**
     * Get contact form configuration for frontend.
     */
    public function config(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'service_interests' => CmsContactSubmission::getServiceInterests(),
                'validation' => [
                    'name' => ['required', 'max:255'],
                    'email' => ['required', 'email', 'max:255'],
                    'phone' => ['nullable', 'max:20'],
                    'subject' => ['nullable', 'max:255'],
                    'message' => ['required', 'max:2000'],
                ],
                'contact_info' => [
                    'phone' => '+52 951 308 4924',
                    'whatsapp' => '+52 951 308 4924',
                    'email' => config('vitalcms.contact.notification_email', 'info@proexna.com'),
                    'business_name' => 'PROEXNA - Profesionalismo en la naturaleza',
                ],
                'features' => [
                    'auto_reply' => config('vitalcms.contact.auto_reply', true),
                    'spam_protection' => config('vitalcms.contact.spam_protection', true),
                ]
            ]
        ]);
    }

    /**
     * Send email notification to admin.
     */
    private function sendEmailNotification(CmsContactSubmission $submission): void
    {
        try {
            $adminEmail = config('vitalcms.contact.notification_email');

            if (!$adminEmail) {
                Log::warning('No admin email configured for contact notifications');
                return;
            }

            // For now, just log the notification
            // In a real implementation, you would use Mail::send() with a proper template
            Log::info('Contact form submission received', [
                'name' => $submission->name,
                'email' => $submission->email,
                'subject' => $submission->subject,
                'service_interest' => $submission->service_interest,
                'id' => $submission->id,
            ]);

            // TODO: Implement actual email sending
            // Mail::send('vitalcms::emails.contact-notification', compact('submission'), function ($message) use ($adminEmail) {
            //     $message->to($adminEmail)->subject('Nuevo mensaje de contacto - PROEXNA');
            // });

        } catch (\Exception $e) {
            Log::error('Failed to send contact notification email', [
                'error' => $e->getMessage(),
                'submission_id' => $submission->id,
            ]);
        }
    }

    /**
     * Send auto-reply to the user.
     */
    private function sendAutoReply(CmsContactSubmission $submission): void
    {
        try {
            // For now, just log the auto-reply
            // In a real implementation, you would send an actual email
            Log::info('Auto-reply would be sent', [
                'to' => $submission->email,
                'name' => $submission->name,
                'submission_id' => $submission->id,
            ]);

            // TODO: Implement actual email sending
            // Mail::send('vitalcms::emails.contact-auto-reply', compact('submission'), function ($message) use ($submission) {
            //     $message->to($submission->email)->subject('Gracias por contactarnos - PROEXNA');
            // });

        } catch (\Exception $e) {
            Log::error('Failed to send auto-reply email', [
                'error' => $e->getMessage(),
                'submission_id' => $submission->id,
            ]);
        }
    }
}