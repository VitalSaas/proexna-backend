@extends("layouts.app")

@section("title", "Blog - PROEXNA")
@section("description", "Consejos, ideas y novedades sobre jardinería, paisajismo y cuidado de áreas verdes.")

@push("styles")
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
<style>
    .font-serif-display { font-family: 'Lora', Georgia, 'Times New Roman', serif; }
    .font-sans-modern  { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
    .eyebrow { letter-spacing: 0.18em; text-transform: uppercase; font-size: 0.75rem; font-weight: 600; }
    .article-card-image { aspect-ratio: 16 / 10; object-fit: cover; width: 100%; }
    .hover-underline { background-image: linear-gradient(currentColor, currentColor); background-position: 0 100%; background-repeat: no-repeat; background-size: 0% 1px; transition: background-size .35s ease; }
    .group:hover .hover-underline { background-size: 100% 1px; }
</style>
@endpush

@section("content")
<!-- Header editorial -->
<header class="bg-white border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-12 text-center font-sans-modern">
        <p class="eyebrow text-green-700 mb-5">PROEXNA · Insights</p>
        <h1 class="font-serif-display text-4xl sm:text-5xl md:text-6xl font-bold text-gray-900 leading-tight mb-6">
            Blog de jardinería y paisajismo profesional
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
            Conocimiento técnico, criterios de diseño y buenas prácticas para conservar áreas verdes saludables y duraderas.
        </p>

        <form action="{{ route('blog.index') }}" method="GET" class="max-w-md mx-auto mt-10">
            <label class="relative block">
                <span class="sr-only">Buscar artículos</span>
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/></svg>
                </span>
                <input type="text" name="q" value="{{ $search }}" placeholder="Buscar artículos..."
                       class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-full text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition">
            </label>
        </form>
    </div>

    @if($availableCategories->count() > 0)
    <nav class="border-t border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 overflow-x-auto">
            <ul class="flex items-center justify-center gap-8 py-4 font-sans-modern text-sm whitespace-nowrap">
                <li>
                    <a href="{{ route('blog.index') }}"
                       class="py-1 border-b-2 transition-colors {{ !$activeCategory ? 'text-green-700 border-green-600 font-semibold' : 'text-gray-600 border-transparent hover:text-gray-900' }}">
                        Todos
                    </a>
                </li>
                @foreach($availableCategories as $cat)
                <li>
                    <a href="{{ route('blog.index', ['categoria' => $cat]) }}"
                       class="py-1 border-b-2 transition-colors {{ $activeCategory === $cat ? 'text-green-700 border-green-600 font-semibold' : 'text-gray-600 border-transparent hover:text-gray-900' }}">
                        {{ $categoryLabels[$cat] ?? ucfirst($cat) }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </nav>
    @endif
</header>

@php
    $isFirstPageNoFilter = !$activeCategory && !$search && $posts->currentPage() === 1;
    $heroPost = $isFirstPageNoFilter ? $featured->first() : null;
    $secondaryFeatured = $isFirstPageNoFilter ? $featured->slice(1, 2) : collect();
    $excludedIds = $isFirstPageNoFilter ? $featured->take(3)->pluck('id')->toArray() : [];
    $gridPosts = $posts->reject(fn ($p) => in_array($p->id, $excludedIds));
@endphp

<!-- Resultados / filtros activos -->
@if($search || $activeCategory)
<section class="bg-gray-50 border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 font-sans-modern text-sm text-gray-600">
        @if($search)
            Resultados para <span class="font-semibold text-gray-900">"{{ $search }}"</span>
        @endif
        @if($activeCategory)
            en <span class="font-semibold text-gray-900">{{ $categoryLabels[$activeCategory] ?? $activeCategory }}</span>
        @endif
        — {{ $posts->total() }} {{ $posts->total() === 1 ? 'artículo' : 'artículos' }}
    </div>
</section>
@endif

<!-- Featured (sólo en primera página sin filtros) -->
@if($heroPost)
<section class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            <!-- Hero post -->
            <article class="lg:col-span-2 group">
                <a href="{{ route('blog.show', $heroPost) }}" class="block">
                    <div class="overflow-hidden rounded-lg mb-6 bg-gray-100">
                        @if($heroPost->image_url)
                            <img src="{{ $heroPost->image_url }}" alt="{{ $heroPost->title }}"
                                 class="w-full h-[420px] object-cover transition-transform duration-700 group-hover:scale-[1.03]">
                        @else
                            <div class="w-full h-[420px] bg-gradient-to-br from-green-700 to-green-900 flex items-center justify-center">
                                <svg class="w-20 h-20 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h10M4 18h7"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="font-sans-modern flex items-center gap-3 text-xs text-gray-500 mb-3">
                        @if($heroPost->category)
                            <span class="eyebrow text-green-700">{{ $categoryLabels[$heroPost->category] ?? $heroPost->category }}</span>
                            <span class="text-gray-300">·</span>
                        @endif
                        @if($heroPost->published_at)
                            <time>{{ $heroPost->published_at->translatedFormat('d \d\e F, Y') }}</time>
                        @endif
                    </div>
                    <h2 class="font-serif-display text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-4 group-hover:text-green-800 transition-colors">
                        {{ $heroPost->title }}
                    </h2>
                    @if($heroPost->excerpt)
                        <p class="font-sans-modern text-lg text-gray-600 leading-relaxed mb-4">
                            {{ Str::limit($heroPost->excerpt, 200) }}
                        </p>
                    @endif
                    <p class="font-sans-modern text-sm text-gray-500">
                        <span class="text-gray-700 font-medium">{{ $heroPost->display_author }}</span>
                        <span class="mx-2 text-gray-300">·</span>
                        <span>{{ $heroPost->reading_time }} min de lectura</span>
                    </p>
                </a>
            </article>

            <!-- Featured secundarios -->
            @if($secondaryFeatured->count() > 0)
            <div class="lg:col-span-1 space-y-8 lg:border-l lg:border-gray-100 lg:pl-10">
                <p class="eyebrow text-gray-500 font-sans-modern hidden lg:block">Lo más reciente</p>
                @foreach($secondaryFeatured as $sec)
                <article class="group">
                    <a href="{{ route('blog.show', $sec) }}" class="block">
                        <div class="overflow-hidden rounded-lg mb-4 bg-gray-100">
                            @if($sec->image_url)
                                <img src="{{ $sec->image_url }}" alt="{{ $sec->title }}"
                                     class="w-full h-44 object-cover transition-transform duration-700 group-hover:scale-[1.03]">
                            @else
                                <div class="w-full h-44 bg-gradient-to-br from-green-600 to-green-800 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h10M4 18h7"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="font-sans-modern flex items-center gap-3 text-xs text-gray-500 mb-2">
                            @if($sec->category)
                                <span class="eyebrow text-green-700">{{ $categoryLabels[$sec->category] ?? $sec->category }}</span>
                            @endif
                        </div>
                        <h3 class="font-serif-display text-xl font-bold text-gray-900 leading-snug mb-2 group-hover:text-green-800 transition-colors">
                            {{ $sec->title }}
                        </h3>
                        <p class="font-sans-modern text-xs text-gray-500">
                            {{ $sec->display_author }} · {{ $sec->reading_time }} min
                        </p>
                    </a>
                </article>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Listado principal -->
<section class="{{ $heroPost ? 'bg-gray-50' : 'bg-white' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if($heroPost)
            <div class="flex items-end justify-between mb-10">
                <div>
                    <p class="eyebrow text-green-700 font-sans-modern mb-2">Más artículos</p>
                    <h2 class="font-serif-display text-3xl font-bold text-gray-900">Todo el blog</h2>
                </div>
            </div>
        @endif

        @if($gridPosts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($gridPosts as $post)
            <article class="group">
                <a href="{{ route('blog.show', $post) }}" class="block">
                    <div class="overflow-hidden rounded-lg mb-5 bg-gray-100">
                        @if($post->image_url)
                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}"
                                 class="article-card-image transition-transform duration-700 group-hover:scale-[1.03]">
                        @else
                            <div class="w-full bg-gradient-to-br from-green-600 to-green-800 flex items-center justify-center" style="aspect-ratio:16/10">
                                <svg class="w-12 h-12 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h10M4 18h7"/></svg>
                            </div>
                        @endif
                    </div>

                    <div class="font-sans-modern flex items-center gap-3 text-xs text-gray-500 mb-3">
                        @if($post->category)
                            <span class="eyebrow text-green-700">{{ $categoryLabels[$post->category] ?? $post->category }}</span>
                            <span class="text-gray-300">·</span>
                        @endif
                        @if($post->published_at)
                            <time>{{ $post->published_at->translatedFormat('d M Y') }}</time>
                        @endif
                    </div>

                    <h3 class="font-serif-display text-xl md:text-2xl font-bold text-gray-900 leading-snug mb-3 group-hover:text-green-800 transition-colors">
                        <span class="hover-underline">{{ $post->title }}</span>
                    </h3>

                    @if($post->excerpt)
                        <p class="font-sans-modern text-gray-600 text-base leading-relaxed mb-4">
                            {{ Str::limit($post->excerpt, 130) }}
                        </p>
                    @endif

                    <div class="font-sans-modern flex items-center justify-between text-xs text-gray-500 pt-4 border-t border-gray-100">
                        <span class="font-medium text-gray-700">{{ $post->display_author }}</span>
                        <span>{{ $post->reading_time }} min</span>
                    </div>
                </a>
            </article>
            @endforeach
        </div>

        <div class="mt-16 font-sans-modern">
            {{ $posts->onEachSide(1)->links() }}
        </div>
        @else
        <div class="text-center py-20 text-gray-500 font-sans-modern">
            <p class="text-lg mb-3">No encontramos artículos con esos criterios.</p>
            <a href="{{ route('blog.index') }}" class="text-green-700 font-medium hover:underline">Ver todos los artículos →</a>
        </div>
        @endif
    </div>
</section>

<!-- Newsletter / CTA -->
<section class="bg-white border-t border-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center font-sans-modern">
        <p class="eyebrow text-green-700 mb-4">Hablemos</p>
        <h2 class="font-serif-display text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            ¿Necesitas asesoría para tu jardín o área verde?
        </h2>
        <p class="text-gray-600 mb-8 max-w-xl mx-auto leading-relaxed">
            Hacemos visitas técnicas y propuestas de mantenimiento o diseño en toda la región de Oaxaca.
        </p>
        <a href="{{ route('contact.index') }}"
           class="inline-block bg-green-700 hover:bg-green-800 text-white font-semibold px-8 py-3.5 rounded-full transition-colors">
            Solicitar visita técnica
        </a>
    </div>
</section>
@endsection
