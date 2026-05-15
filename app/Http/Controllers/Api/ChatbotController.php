<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use App\Models\Post;
use App\Models\Project;
use App\Models\Prospect;
use App\Models\Sector;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\WelcomeSection;
use App\Models\WhyChooseUsItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChatbotController extends Controller
{
    public function projects(): JsonResponse
    {
        $projects = Project::active()->ordered()->limit(40)->get();
        $categories = Project::getCategories();

        return response()->json(
            $projects->map(fn (Project $p) => [
                'slug' => $p->slug,
                'title' => $p->title,
                'short_description' => $p->short_description,
                'client' => $p->client,
                'location' => $p->location,
                'category' => $categories[$p->category] ?? $p->category,
                'completed_at' => optional($p->completed_at)->toDateString(),
                'featured' => (bool) $p->featured,
                'url' => url('/proyectos/'.$p->slug),
            ])->all()
        );
    }

    public function sectors(): JsonResponse
    {
        return response()->json(
            Sector::active()->ordered()->get()->map(fn (Sector $s) => [
                'title' => $s->title,
                'description' => $s->description,
            ])->all()
        );
    }

    public function testimonials(): JsonResponse
    {
        return response()->json(
            Testimonial::active()->ordered()->limit(15)->get()->map(fn (Testimonial $t) => [
                'name' => $t->name,
                'role' => $t->role,
                'company' => $t->company,
                'quote' => $t->quote,
                'rating' => $t->rating,
            ])->all()
        );
    }

    public function vacancies(): JsonResponse
    {
        return response()->json(
            JobVacancy::active()->ordered()->get()->map(fn (JobVacancy $v) => [
                'slug' => $v->slug,
                'title' => $v->title,
                'department' => $v->department,
                'location' => $v->location,
                'employment_type' => $v->employment_type_label,
                'salary_range' => $v->salary_range,
                'short_description' => $v->short_description,
                'closes_at' => optional($v->closes_at)->toDateString(),
                'url' => url('/carreras/'.$v->slug),
            ])->all()
        );
    }

    public function stats(): JsonResponse
    {
        return response()->json(
            Stat::where('is_active', true)->orderBy('sort_order')->get()->map(fn (Stat $s) => [
                'value' => $s->value,
                'label' => $s->label,
            ])->all()
        );
    }

    public function whyChooseUs(): JsonResponse
    {
        return response()->json(
            WhyChooseUsItem::where('is_active', true)->orderBy('sort_order')->get()->map(fn (WhyChooseUsItem $w) => [
                'title' => $w->title,
                'description' => $w->description,
            ])->all()
        );
    }

    public function posts(): JsonResponse
    {
        return response()->json(
            Post::where('status', 'published')
                ->orderByDesc('published_at')
                ->limit(10)
                ->get()
                ->map(fn (Post $p) => [
                    'slug' => $p->slug,
                    'title' => $p->title,
                    'excerpt' => $p->excerpt,
                    'category' => $p->category,
                    'published_at' => optional($p->published_at)->toDateString(),
                    'url' => url('/blog/'.$p->slug),
                ])->all()
        );
    }

    public function storeProspect(Request $request): JsonResponse
    {
        // Normalizar strings vacíos a null antes de validar (el chatbot puede
        // mandar "" cuando la IA no extrae el dato).
        $request->merge(array_map(
            fn ($v) => is_string($v) && trim($v) === '' ? null : $v,
            $request->all(),
        ));

        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'company' => ['nullable', 'string', 'max:150'],
            'interest' => ['nullable', 'string', 'max:2000'],
            'budget_range' => ['nullable', 'string', 'max:60'],
            'tentative_service_date' => ['nullable', 'date'],
            'source' => ['nullable', Rule::in(array_keys(Prospect::getSources()))],
            'chatbot_conversation_id' => ['nullable', 'string', 'max:120'],
            'chatbot_payload' => ['nullable', 'array'],
        ]);

        if (empty($data['email']) && empty($data['phone'])) {
            return response()->json([
                'message' => 'Debe proporcionar al menos un email o teléfono de contacto.',
                'errors' => [
                    'email' => ['Se requiere email o teléfono.'],
                    'phone' => ['Se requiere email o teléfono.'],
                ],
            ], 422);
        }

        $attributes = [
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'company' => $data['company'] ?? null,
            'interest' => $data['interest'] ?? null,
            'budget_range' => $data['budget_range'] ?? null,
            'tentative_service_date' => $data['tentative_service_date'] ?? null,
            'source' => $data['source'] ?? 'chatbot',
            'chatbot_payload' => $data['chatbot_payload'] ?? null,
        ];

        // Dedup por conversación: si el chatbot reintenta, actualizamos el
        // mismo prospecto en lugar de crear duplicados.
        $conversationId = $data['chatbot_conversation_id'] ?? null;

        if ($conversationId) {
            $prospect = Prospect::firstOrNew([
                'chatbot_conversation_id' => $conversationId,
            ]);

            $wasNew = ! $prospect->exists;

            $prospect->fill($attributes);
            if ($wasNew) {
                $prospect->status = 'new';
            }
            $prospect->save();

            return response()->json([
                'id' => $prospect->id,
                'status' => $prospect->status,
                'created_at' => $prospect->created_at->toIso8601String(),
            ], $wasNew ? 201 : 200);
        }

        $prospect = Prospect::create($attributes + [
            'status' => 'new',
            'chatbot_conversation_id' => null,
        ]);

        return response()->json([
            'id' => $prospect->id,
            'status' => $prospect->status,
            'created_at' => $prospect->created_at->toIso8601String(),
        ], 201);
    }

    public function company(): JsonResponse
    {
        $welcome = WelcomeSection::where('is_active', true)->orderBy('sort_order')->first();

        return response()->json([
            'name' => 'PROEXNA',
            'tagline' => 'Servicios profesionales de jardinería y paisajismo',
            'phone' => '+52 951 308 4924',
            'phone_display' => '951 308 4924',
            'whatsapp' => 'https://wa.me/529513084924',
            'email' => 'info@proexna.com',
            'website' => url('/'),
            'welcome' => $welcome ? [
                'title' => $welcome->title,
                'content' => strip_tags($welcome->content ?? ''),
            ] : null,
        ]);
    }
}
