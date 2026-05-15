@extends("layouts.app")

@section("title", "Bolsa de Trabajo - PROEXNA")
@section("description", "Únete al equipo PROEXNA. Consulta nuestras vacantes disponibles o déjanos tus datos para futuras oportunidades.")

@section("content")
<!-- Hero -->
<div class="gradient-green text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6 text-4xl">
                💼
            </div>
        </div>
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-6">
            Bolsa de Trabajo
        </h1>
        <p class="text-xl mb-8 max-w-3xl mx-auto">
            Forma parte del equipo PROEXNA. Buscamos personas apasionadas por la naturaleza y los espacios verdes.
        </p>
    </div>
</div>

@if(session("success"))
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded">
        {{ session("success") }}
    </div>
</div>
@endif

@if($hasVacancies)
<!-- Vacantes Disponibles -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Vacantes Disponibles</h2>
            <p class="text-lg text-gray-600">Estas son las posiciones abiertas actualmente</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($vacancies as $vacancy)
            <a href="{{ route('careers.show', $vacancy) }}" class="block bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 p-6 border-l-4 border-green-500">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-xl font-bold text-gray-900">{{ $vacancy->title }}</h3>
                    @if($vacancy->employment_type_label)
                        <span class="text-xs text-green-700 bg-green-100 px-2 py-1 rounded whitespace-nowrap ml-3">
                            {{ $vacancy->employment_type_label }}
                        </span>
                    @endif
                </div>

                @if($vacancy->short_description)
                    <p class="text-gray-600 mb-4">{{ $vacancy->short_description }}</p>
                @endif

                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-4">
                    @if($vacancy->department)
                        <span>🏢 {{ $vacancy->department }}</span>
                    @endif
                    @if($vacancy->location)
                        <span>📍 {{ $vacancy->location }}</span>
                    @endif
                    @if($vacancy->salary_range)
                        <span>💰 {{ $vacancy->salary_range }}</span>
                    @endif
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    @if($vacancy->closes_at)
                        <span class="text-xs text-gray-500">Cierra: {{ $vacancy->closes_at->format('d/m/Y') }}</span>
                    @else
                        <span class="text-xs text-gray-500">Postulación abierta</span>
                    @endif
                    <span class="text-green-600 font-medium">Ver y postular →</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Postulación abierta también disponible -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-3">¿No encuentras la vacante ideal?</h2>
                <p class="text-gray-600">Déjanos tus datos y te contactaremos cuando abramos una posición que se ajuste a tu perfil.</p>
            </div>

            @include('careers.partials.application-form', ['action' => route('careers.storeOpen'), 'isOpen' => true])
        </div>
    </div>
</section>
@else
<!-- Sin vacantes — postulación abierta -->
<section class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg p-8 md:p-12">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4 text-3xl">
                    📋
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">No hay vacantes abiertas en este momento</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Pero seguimos creciendo. Déjanos tus datos y te llamaremos cuando se abra una posición que coincida con tu perfil.
                </p>
            </div>

            @include('careers.partials.application-form', ['action' => route('careers.storeOpen'), 'isOpen' => true])
        </div>
    </div>
</section>
@endif

<!-- Por qué trabajar con nosotros -->
<section class="py-16 bg-green-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">¿Por qué PROEXNA?</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg p-6 text-center shadow">
                <div class="text-4xl mb-4">🌱</div>
                <h3 class="font-bold text-lg mb-2">Trabajo con propósito</h3>
                <p class="text-gray-600 text-sm">Transformamos espacios y mejoramos vidas con áreas verdes saludables.</p>
            </div>
            <div class="bg-white rounded-lg p-6 text-center shadow">
                <div class="text-4xl mb-4">📈</div>
                <h3 class="font-bold text-lg mb-2">Crecimiento</h3>
                <p class="text-gray-600 text-sm">Capacitación constante y oportunidades de desarrollo profesional.</p>
            </div>
            <div class="bg-white rounded-lg p-6 text-center shadow">
                <div class="text-4xl mb-4">🤝</div>
                <h3 class="font-bold text-lg mb-2">Equipo</h3>
                <p class="text-gray-600 text-sm">Un ambiente colaborativo donde tu trabajo se valora.</p>
            </div>
        </div>
    </div>
</section>
@endsection
