@extends("layouts.app")

@section("title", $post->title . " - Blog PROEXNA")
@section("description", $post->excerpt ?? Str::limit(strip_tags($post->content ?? ''), 160))

@push("styles")
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
<style>
    .font-serif-display { font-family: 'Lora', Georgia, 'Times New Roman', serif; }
    .font-sans-modern  { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
    .eyebrow { letter-spacing: 0.18em; text-transform: uppercase; font-size: 0.75rem; font-weight: 600; }

    .article-body {
        font-family: 'Lora', Georgia, serif;
        font-size: 1.125rem;
        line-height: 1.85;
        color: #1f2937;
    }
    .article-body p { margin: 0 0 1.5rem; }
    .article-body p:first-of-type::first-letter {
        font-family: 'Lora', serif;
        font-weight: 700;
        font-size: 3.75rem;
        line-height: 0.95;
        float: left;
        padding: 0.35rem 0.7rem 0 0;
        color: #15803d;
    }
    .article-body h2 {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: #111827;
        margin: 2.75rem 0 1rem;
        letter-spacing: -0.01em;
        line-height: 1.3;
    }
    .article-body h3 {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin: 2.25rem 0 0.75rem;
        line-height: 1.35;
    }
    .article-body a {
        color: #15803d;
        text-decoration: underline;
        text-decoration-thickness: 1px;
        text-underline-offset: 3px;
        font-weight: 500;
    }
    .article-body a:hover { color: #14532d; text-decoration-thickness: 2px; }
    .article-body ul, .article-body ol { margin: 0 0 1.5rem 1.5rem; }
    .article-body ul { list-style-type: disc; }
    .article-body ol { list-style-type: decimal; }
    .article-body li { margin-bottom: 0.6rem; padding-left: 0.25rem; }
    .article-body li::marker { color: #15803d; }
    .article-body strong { color: #111827; font-weight: 700; }
    .article-body em { color: #374151; }
    .article-body img {
        border-radius: 0.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        margin: 2.5rem auto;
        max-width: 100%;
        height: auto;
    }
    .article-body blockquote {
        border-left: 4px solid #15803d;
        padding: 0.25rem 0 0.25rem 1.5rem;
        font-style: italic;
        color: #4b5563;
        margin: 2rem 0;
        font-size: 1.25rem;
        line-height: 1.6;
    }
    .article-body hr { border: 0; border-top: 1px solid #e5e7eb; margin: 2.5rem 0; }
</style>
@endpush

@section("content")
@php
    $shareUrl = request()->fullUrl();
@endphp

<!-- Header del artículo -->
<header class="bg-white border-b border-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-10 font-sans-modern">
        <nav class="text-xs text-gray-500 mb-8 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-green-700 transition-colors">Inicio</a>
            <span class="text-gray-300">/</span>
            <a href="{{ route('blog.index') }}" class="hover:text-green-700 transition-colors">Blog</a>
            @if($post->category)
                <span class="text-gray-300">/</span>
                <a href="{{ route('blog.index', ['categoria' => $post->category]) }}" class="hover:text-green-700 transition-colors">
                    {{ $categoryLabels[$post->category] ?? $post->category }}
                </a>
            @endif
        </nav>

        @if($post->category)
            <a href="{{ route('blog.index', ['categoria' => $post->category]) }}"
               class="eyebrow text-green-700 hover:text-green-900 transition-colors inline-block mb-5">
                {{ $categoryLabels[$post->category] ?? $post->category }}
            </a>
        @endif

        <h1 class="font-serif-display text-4xl sm:text-5xl font-bold text-gray-900 leading-tight mb-6">
            {{ $post->title }}
        </h1>

        @if($post->excerpt)
            <p class="font-serif-display text-xl text-gray-600 leading-relaxed italic mb-8">
                {{ $post->excerpt }}
            </p>
        @endif

        <div class="flex flex-wrap items-center gap-x-6 gap-y-3 text-sm text-gray-600 pt-6 border-t border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-semibold">
                    {{ strtoupper(mb_substr($post->display_author, 0, 1)) }}
                </div>
                <div>
                    <div class="font-medium text-gray-900">{{ $post->display_author }}</div>
                    @if($post->published_at)
                        <div class="text-xs text-gray-500">
                            {{ $post->published_at->translatedFormat('d \d\e F \d\e Y') }}
                            <span class="text-gray-300 mx-1">·</span>
                            {{ $post->reading_time }} min de lectura
                        </div>
                    @endif
                </div>
            </div>

            <div class="ml-auto flex items-center gap-2 text-xs text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <span>{{ number_format($post->views_count) }}</span>
            </div>
        </div>
    </div>
</header>

<!-- Imagen destacada -->
@if($post->image_url)
<div class="bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <figure class="rounded-lg overflow-hidden shadow-lg">
            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full max-h-[560px] object-cover">
        </figure>
    </div>
</div>
@endif

<!-- Cuerpo del artículo -->
<article class="bg-white pt-14 pb-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="article-body">
            {!! $post->content !!}
        </div>

        <!-- Pie del artículo -->
        <div class="mt-14 pt-8 border-t border-gray-200 font-sans-modern flex flex-wrap items-center justify-between gap-6">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-gray-700 hover:text-green-700 font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Volver al blog
            </a>

            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Compartir</span>
                <a href="https://wa.me/?text={{ urlencode($post->title . ' — ' . $shareUrl) }}" target="_blank" rel="noopener"
                   aria-label="Compartir por WhatsApp"
                   class="w-9 h-9 rounded-full bg-gray-100 hover:bg-green-600 hover:text-white text-gray-700 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.247-.694.247-1.289.173-1.413z"/></svg>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener"
                   aria-label="Compartir en Facebook"
                   class="w-9 h-9 rounded-full bg-gray-100 hover:bg-[#1877F2] hover:text-white text-gray-700 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode($shareUrl) }}" target="_blank" rel="noopener"
                   aria-label="Compartir en X"
                   class="w-9 h-9 rounded-full bg-gray-100 hover:bg-black hover:text-white text-gray-700 flex items-center justify-center transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($shareUrl) }}" target="_blank" rel="noopener"
                   aria-label="Compartir en LinkedIn"
                   class="w-9 h-9 rounded-full bg-gray-100 hover:bg-[#0A66C2] hover:text-white text-gray-700 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.063 2.063 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                </a>
            </div>
        </div>
    </div>
</article>

<!-- Posts Relacionados -->
@if($relatedPosts->count() > 0)
<section class="bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 font-sans-modern">
        <div class="text-center mb-14">
            <p class="eyebrow text-green-700 mb-3">Sigue leyendo</p>
            <h2 class="font-serif-display text-3xl md:text-4xl font-bold text-gray-900">Artículos relacionados</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach($relatedPosts as $related)
            <article class="group">
                <a href="{{ route('blog.show', $related) }}" class="block">
                    <div class="overflow-hidden rounded-lg mb-5 bg-gray-100">
                        @if($related->image_url)
                            <img src="{{ $related->image_url }}" alt="{{ $related->title }}"
                                 class="w-full h-52 object-cover transition-transform duration-700 group-hover:scale-[1.03]">
                        @else
                            <div class="w-full h-52 bg-gradient-to-br from-green-600 to-green-800 flex items-center justify-center">
                                <svg class="w-12 h-12 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h10M4 18h7"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex items-center gap-3 text-xs text-gray-500 mb-2">
                        @if($related->category)
                            <span class="eyebrow text-green-700">{{ $categoryLabels[$related->category] ?? $related->category }}</span>
                            <span class="text-gray-300">·</span>
                        @endif
                        @if($related->published_at)
                            <time>{{ $related->published_at->translatedFormat('d M Y') }}</time>
                        @endif
                    </div>
                    <h3 class="font-serif-display text-xl font-bold text-gray-900 leading-snug mb-2 group-hover:text-green-800 transition-colors">
                        {{ Str::limit($related->title, 70) }}
                    </h3>
                    @if($related->excerpt)
                        <p class="text-gray-600 text-sm leading-relaxed">{{ Str::limit($related->excerpt, 110) }}</p>
                    @endif
                </a>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA final -->
<section class="bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center font-sans-modern">
        <p class="eyebrow text-green-700 mb-4">Conversemos</p>
        <h2 class="font-serif-display text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            ¿Quieres aplicar esto en tu jardín?
        </h2>
        <p class="text-gray-600 mb-8 max-w-xl mx-auto leading-relaxed">
            Realizamos visitas técnicas y propuestas a la medida en toda la región de Oaxaca.
        </p>
        <a href="{{ route('contact.index') }}"
           class="inline-block bg-green-700 hover:bg-green-800 text-white font-semibold px-8 py-3.5 rounded-full transition-colors">
            Solicitar cotización
        </a>
    </div>
</section>
@endsection
