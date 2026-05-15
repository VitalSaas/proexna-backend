@extends("layouts.app")

@section("title", $vacancy->title . " - Bolsa de Trabajo PROEXNA")
@section("description", $vacancy->short_description ?? "Postúlate al puesto de " . $vacancy->title . " en PROEXNA")

@section("content")
<!-- Hero -->
<div class="bg-gradient-to-br from-green-600 to-green-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-sm text-green-100 mb-6">
            <a href="{{ route('home') }}" class="hover:text-white">Inicio</a>
            <span class="mx-2">›</span>
            <a href="{{ route('careers.index') }}" class="hover:text-white">Bolsa de Trabajo</a>
            <span class="mx-2">›</span>
            <span>{{ $vacancy->title }}</span>
        </nav>
        <div class="text-center">
            <h1 class="text-4xl sm:text-5xl font-bold mb-4">{{ $vacancy->title }}</h1>
            @if($vacancy->short_description)
                <p class="text-xl mb-6 max-w-3xl mx-auto">{{ $vacancy->short_description }}</p>
            @endif
            <div class="flex flex-wrap items-center justify-center gap-3 text-base">
                @if($vacancy->employment_type_label)
                    <span class="bg-white bg-opacity-20 px-4 py-2 rounded-lg">{{ $vacancy->employment_type_label }}</span>
                @endif
                @if($vacancy->location)
                    <span class="bg-white bg-opacity-20 px-4 py-2 rounded-lg">📍 {{ $vacancy->location }}</span>
                @endif
                @if($vacancy->department)
                    <span class="bg-white bg-opacity-20 px-4 py-2 rounded-lg">🏢 {{ $vacancy->department }}</span>
                @endif
            </div>
        </div>
    </div>
</div>

@if(session("success"))
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded">
        {{ session("success") }}
    </div>
</div>
@endif

<!-- Contenido + Form -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2">
                @if($vacancy->description)
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Sobre el puesto</h2>
                    <div class="prose prose-lg max-w-none text-gray-700 mb-8">
                        {!! $vacancy->description !!}
                    </div>
                @endif

                @if($vacancy->requirements)
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">Requisitos</h2>
                    <div class="prose prose-lg max-w-none text-gray-700 mb-8">
                        {!! $vacancy->requirements !!}
                    </div>
                @endif

                @if($vacancy->benefits)
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">Beneficios</h2>
                    <div class="prose prose-lg max-w-none text-gray-700 mb-8">
                        {!! $vacancy->benefits !!}
                    </div>
                @endif
            </div>

            <aside class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Ficha</h3>

                    @if($vacancy->employment_type_label)
                        <div class="mb-3">
                            <span class="text-sm font-medium text-gray-500">Tipo</span>
                            <div class="text-base font-semibold text-gray-900">{{ $vacancy->employment_type_label }}</div>
                        </div>
                    @endif

                    @if($vacancy->department)
                        <div class="mb-3">
                            <span class="text-sm font-medium text-gray-500">Área</span>
                            <div class="text-base font-semibold text-gray-900">{{ $vacancy->department }}</div>
                        </div>
                    @endif

                    @if($vacancy->location)
                        <div class="mb-3">
                            <span class="text-sm font-medium text-gray-500">Ubicación</span>
                            <div class="text-base font-semibold text-gray-900">{{ $vacancy->location }}</div>
                        </div>
                    @endif

                    @if($vacancy->salary_range)
                        <div class="mb-3">
                            <span class="text-sm font-medium text-gray-500">Salario</span>
                            <div class="text-base font-semibold text-gray-900">{{ $vacancy->salary_range }}</div>
                        </div>
                    @endif

                    @if($vacancy->posted_at)
                        <div class="mb-3">
                            <span class="text-sm font-medium text-gray-500">Publicada</span>
                            <div class="text-base font-semibold text-gray-900">{{ $vacancy->posted_at->format('d/m/Y') }}</div>
                        </div>
                    @endif

                    @if($vacancy->closes_at)
                        <div class="mb-3">
                            <span class="text-sm font-medium text-gray-500">Cierra</span>
                            <div class="text-base font-semibold text-gray-900">{{ $vacancy->closes_at->format('d/m/Y') }}</div>
                        </div>
                    @endif

                    <a href="#postular" class="block mt-6 bg-green-600 text-white text-center px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition-colors">
                        Postularme
                    </a>
                </div>
            </aside>
        </div>
    </div>
</section>

<!-- Formulario de Postulación -->
<section id="postular" class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Postúlate a esta vacante</h2>
                <p class="text-gray-600">Completa el formulario y nos pondremos en contacto contigo.</p>
            </div>

            @include('careers.partials.application-form', ['action' => route('careers.apply', $vacancy), 'isOpen' => false])
        </div>
    </div>
</section>
@endsection
