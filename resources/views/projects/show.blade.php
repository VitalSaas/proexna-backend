@extends("layouts.app")

@section("title", $project->title . " - PROEXNA")
@section("description", $project->short_description ?? '')

@section("content")
<!-- Hero del Proyecto -->
<div class="bg-gradient-to-br from-green-600 to-green-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-sm text-green-100 mb-6">
            <a href="{{ route('home') }}" class="hover:text-white">Inicio</a>
            <span class="mx-2">›</span>
            <a href="{{ route('projects.index') }}" class="hover:text-white">Proyectos</a>
            <span class="mx-2">›</span>
            <span>{{ $project->title }}</span>
        </nav>
        <div class="text-center">
            <h1 class="text-4xl sm:text-5xl font-bold mb-4">{{ $project->title }}</h1>
            @if($project->short_description)
                <p class="text-xl mb-6 max-w-3xl mx-auto">{{ $project->short_description }}</p>
            @endif
            <div class="flex flex-wrap items-center justify-center gap-3 text-lg">
                @if($project->category)
                    <span class="bg-white bg-opacity-20 px-4 py-2 rounded-lg">
                        {{ $categoryLabels[$project->category] ?? $project->category }}
                    </span>
                @endif
                @if($project->location)
                    <span class="bg-white bg-opacity-20 px-4 py-2 rounded-lg">📍 {{ $project->location }}</span>
                @endif
                @if($project->completed_at)
                    <span class="bg-white bg-opacity-20 px-4 py-2 rounded-lg">📅 {{ $project->completed_at->format('d/m/Y') }}</span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Imagen Principal -->
@if($project->image_url)
<section class="py-12"
         x-data="{
            open: false,
            src: @js($project->image_url),
            title: @js($project->title),
            show() { this.open = true; document.body.style.overflow = 'hidden'; },
            close() { this.open = false; document.body.style.overflow = ''; },
         }"
         @keydown.escape.window="open && close()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <button type="button" @click="show()"
                class="block w-full rounded-xl overflow-hidden shadow-xl group focus:outline-none focus:ring-2 focus:ring-green-500"
                aria-label="Ampliar imagen">
            <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full max-h-[600px] object-cover group-hover:scale-[1.02] transition-transform duration-300">
        </button>
    </div>

    <!-- Lightbox imagen principal -->
    <div x-show="open" x-cloak
         x-transition.opacity
         @click.self="close()"
         class="fixed inset-0 z-[60] bg-black/90 flex items-center justify-center p-4 select-none">

        <button type="button" @click="close()" aria-label="Cerrar"
                class="absolute top-4 right-4 text-white/80 hover:text-white bg-white/10 hover:bg-white/20 rounded-full w-11 h-11 flex items-center justify-center text-2xl leading-none transition">
            &times;
        </button>

        <img :src="src" :alt="title"
             @click.stop
             class="max-h-[85vh] max-w-[90vw] object-contain rounded shadow-2xl">
    </div>
</section>
@endif

<!-- Contenido + Sidebar -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Sobre el Proyecto</h2>
                <div class="prose prose-lg max-w-none text-gray-700 mb-8">
                    @if($project->description)
                        {!! $project->description !!}
                    @else
                        <p>{{ $project->short_description }}</p>
                    @endif
                </div>

                @if(!empty($project->gallery_urls))
                @php
                    $galleryImages = array_values($project->gallery_urls);
                @endphp
                <div class="mt-12"
                     x-data="{
                        open: false,
                        index: 0,
                        images: @js($galleryImages),
                        title: @js($project->title),
                        show(i) { this.index = i; this.open = true; document.body.style.overflow = 'hidden'; },
                        close() { this.open = false; document.body.style.overflow = ''; },
                        next() { this.index = (this.index + 1) % this.images.length; },
                        prev() { this.index = (this.index - 1 + this.images.length) % this.images.length; },
                     }"
                     @keydown.escape.window="open && close()"
                     @keydown.arrow-right.window="open && next()"
                     @keydown.arrow-left.window="open && prev()">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Galería</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($galleryImages as $i => $img)
                            <button type="button"
                                    @click="show({{ $i }})"
                                    class="group block overflow-hidden rounded-lg shadow hover:shadow-lg transition-shadow focus:outline-none focus:ring-2 focus:ring-green-500">
                                <img src="{{ $img }}" alt="{{ $project->title }} — imagen {{ $i + 1 }}" loading="lazy" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            </button>
                        @endforeach
                    </div>

                    <!-- Lightbox -->
                    <div x-show="open" x-cloak
                         x-transition.opacity
                         @click.self="close()"
                         class="fixed inset-0 z-[60] bg-black/90 flex items-center justify-center p-4 select-none">

                        <button type="button" @click="close()" aria-label="Cerrar"
                                class="absolute top-4 right-4 text-white/80 hover:text-white bg-white/10 hover:bg-white/20 rounded-full w-11 h-11 flex items-center justify-center text-2xl leading-none transition">
                            &times;
                        </button>

                        <div class="absolute top-4 left-4 text-white/80 text-sm bg-white/10 px-3 py-1 rounded-full">
                            <span x-text="index + 1"></span> / <span x-text="images.length"></span>
                        </div>

                        <button type="button" @click.stop="prev()" x-show="images.length > 1" aria-label="Anterior"
                                class="absolute left-2 sm:left-6 top-1/2 -translate-y-1/2 text-white/80 hover:text-white bg-white/10 hover:bg-white/20 rounded-full w-12 h-12 flex items-center justify-center text-3xl transition">
                            &#8249;
                        </button>

                        <img :src="images[index]" :alt="title"
                             @click.stop
                             class="max-h-[85vh] max-w-[90vw] object-contain rounded shadow-2xl">

                        <button type="button" @click.stop="next()" x-show="images.length > 1" aria-label="Siguiente"
                                class="absolute right-2 sm:right-6 top-1/2 -translate-y-1/2 text-white/80 hover:text-white bg-white/10 hover:bg-white/20 rounded-full w-12 h-12 flex items-center justify-center text-3xl transition">
                            &#8250;
                        </button>
                    </div>
                </div>
                @endif
            </div>

            <aside class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Ficha del Proyecto</h3>

                    @if($project->client)
                        <div class="mb-3">
                            <span class="text-sm font-medium text-gray-500">Cliente</span>
                            <div class="text-base font-semibold text-gray-900">{{ $project->client }}</div>
                        </div>
                    @endif

                    @if($project->location)
                        <div class="mb-3">
                            <span class="text-sm font-medium text-gray-500">Ubicación</span>
                            <div class="text-base font-semibold text-gray-900">{{ $project->location }}</div>
                        </div>
                    @endif

                    @if($project->category)
                        <div class="mb-3">
                            <span class="text-sm font-medium text-gray-500">Categoría</span>
                            <div class="text-base font-semibold text-gray-900">{{ $categoryLabels[$project->category] ?? $project->category }}</div>
                        </div>
                    @endif

                    @if($project->completed_at)
                        <div class="mb-3">
                            <span class="text-sm font-medium text-gray-500">Finalizado</span>
                            <div class="text-base font-semibold text-gray-900">{{ $project->completed_at->format('d/m/Y') }}</div>
                        </div>
                    @endif

                    @if(!empty($project->meta_data) && is_array($project->meta_data))
                        <div class="border-t pt-4 mt-4 space-y-2">
                            @foreach($project->meta_data as $key => $value)
                                <div class="text-sm">
                                    <span class="text-gray-500">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                    <span class="text-gray-900 font-medium">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="bg-green-600 text-white rounded-lg p-6 text-center">
                    <h3 class="text-xl font-bold mb-3">¿Quieres un proyecto similar?</h3>
                    <p class="mb-6 text-sm">Cuéntanos tu idea y te damos una cotización personalizada.</p>
                    <a href="{{ route('contact.index') }}" class="bg-white text-green-600 px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors inline-block">
                        Solicitar Cotización
                    </a>
                </div>
            </aside>
        </div>
    </div>
</section>

<!-- Proyectos Relacionados -->
@if($relatedProjects->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Otros Proyectos</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedProjects as $related)
            <a href="{{ route('projects.show', $related) }}" class="block bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                @if($related->image_url)
                    <img src="{{ $related->image_url }}" alt="{{ $related->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                        <span class="text-4xl">🌿</span>
                    </div>
                @endif
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $related->title }}</h3>
                    @if($related->short_description)
                        <p class="text-gray-600 text-sm">{{ Str::limit($related->short_description, 100) }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
