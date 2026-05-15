@extends("layouts.app")

@section("title", "Proyectos - PROEXNA")

@section("content")
<!-- Hero -->
<div class="gradient-green text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6 text-4xl">
                🌳
            </div>
        </div>
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-6">
            Nuestros Proyectos
        </h1>
        <p class="text-xl mb-8 max-w-3xl mx-auto">
            Una muestra de los trabajos realizados: jardines, paisajismo, instalaciones y mantenimientos en residencias y espacios comerciales.
        </p>
    </div>
</div>

<!-- Proyectos Destacados -->
@if($featuredProjects->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Proyectos Destacados</h2>
            <p class="text-lg text-gray-600">Los trabajos que mejor representan nuestro estilo</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredProjects as $project)
            <a href="{{ route('projects.show', $project) }}" class="block bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                @if($project->image_url)
                    <div class="h-56 bg-cover bg-center" style="background-image: url('{{ $project->image_url }}')"></div>
                @else
                    <div class="h-56 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                        <span class="text-5xl">🌿</span>
                    </div>
                @endif
                <div class="p-6">
                    @if($project->category)
                        <span class="inline-block text-xs text-green-700 bg-green-100 px-2 py-1 rounded mb-3">
                            {{ $categoryLabels[$project->category] ?? $project->category }}
                        </span>
                    @endif
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $project->title }}</h3>
                    @if($project->short_description)
                        <p class="text-gray-600 mb-4">{{ $project->short_description }}</p>
                    @endif
                    <span class="text-green-600 font-medium">Ver proyecto →</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Todos los Proyectos -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Todos los Proyectos</h2>
            <p class="text-lg text-gray-600">Explora el portafolio completo</p>
        </div>

        @if($availableCategories->count() > 0)
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            <a href="{{ route('projects.index') }}"
               class="px-4 py-2 rounded-full transition-colors duration-300 {{ !$activeCategory ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Todos
            </a>
            @foreach($availableCategories as $cat)
            <a href="{{ route('projects.index', ['categoria' => $cat]) }}"
               class="px-4 py-2 rounded-full transition-colors duration-300 {{ $activeCategory === $cat ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                {{ $categoryLabels[$cat] ?? ucfirst($cat) }}
            </a>
            @endforeach
        </div>
        @endif

        @if($projects->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($projects as $project)
            <a href="{{ route('projects.show', $project) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                @if($project->image_url)
                    <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $project->image_url }}')"></div>
                @else
                    <div class="h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                        <span class="text-4xl">🌿</span>
                    </div>
                @endif
                <div class="p-5">
                    <div class="flex items-center justify-between mb-2">
                        @if($project->category)
                            <span class="text-xs text-green-700 bg-green-100 px-2 py-1 rounded">
                                {{ $categoryLabels[$project->category] ?? $project->category }}
                            </span>
                        @endif
                        @if($project->completed_at)
                            <span class="text-xs text-gray-500">{{ $project->completed_at->format('m/Y') }}</span>
                        @endif
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $project->title }}</h3>
                    @if($project->short_description)
                        <p class="text-gray-600 text-sm mb-3">{{ Str::limit($project->short_description, 100) }}</p>
                    @endif
                    @if($project->location)
                        <p class="text-xs text-gray-500">📍 {{ $project->location }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 text-gray-500">
            <p>Aún no hay proyectos publicados en esta categoría.</p>
        </div>
        @endif
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-green-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">¿Quieres un proyecto así?</h2>
        <p class="text-xl mb-8">Contáctanos para cotizar tu jardín o espacio verde.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact.index') }}" class="bg-white text-green-600 px-8 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors">
                Solicitar Cotización
            </a>
            <a href="https://wa.me/529513084924" target="_blank" class="border-2 border-white text-white px-8 py-3 rounded-lg font-medium hover:bg-white hover:text-green-600 transition-colors">
                💬 WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection
