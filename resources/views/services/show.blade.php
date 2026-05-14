@extends("layouts.app")

@section("title", $service->title . " - PROEXNA")

@section("content")
<!-- Hero Section del Servicio -->
<div class="bg-gradient-to-br from-green-600 to-green-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl sm:text-5xl font-bold mb-4">{{ $service->title }}</h1>
            @if($service->short_description)
                <p class="text-xl mb-6 max-w-3xl mx-auto">{{ $service->short_description }}</p>
            @endif
            <div class="flex items-center justify-center space-x-4 text-lg">
                @if($service->category)
                    <span class="bg-white bg-opacity-20 px-4 py-2 rounded-lg">{{ ucfirst(str_replace(["_", "-"], " ", $service->category)) }}</span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Imagen Principal del Servicio -->
@if($service->image_url)
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-xl overflow-hidden shadow-xl">
            <img src="{{ $service->image_url }}"
                 alt="{{ $service->title }}"
                 class="w-full h-96 object-cover">
        </div>
    </div>
</section>
@endif

<!-- Contenido Principal -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Descripción del Servicio -->
            <div class="lg:col-span-2">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Descripción del Servicio</h2>
                <div class="prose prose-lg text-gray-600 mb-8">
                    @if($service->description)
                        {!! nl2br(e($service->description)) !!}
                    @else
                        <p>{{ $service->short_description }}</p>
                    @endif
                </div>

                <!-- Características del Servicio -->
                <div class="bg-green-50 rounded-lg p-8 mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">¿Por qué elegir este servicio?</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center">
                            <span class="text-green-600 text-xl mr-3">✓</span>
                            <span class="text-gray-700">Profesionales certificados</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-600 text-xl mr-3">✓</span>
                            <span class="text-gray-700">Garantía de calidad</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-600 text-xl mr-3">✓</span>
                            <span class="text-gray-700">Materiales de primera</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-600 text-xl mr-3">✓</span>
                            <span class="text-gray-700">Atención personalizada</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar con información -->
            <div class="lg:col-span-1">
                <!-- Información del Servicio -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Información del Servicio</h3>
                    
                    @if($service->category)
                        <div class="mb-4">
                            <span class="text-sm font-medium text-gray-500">Categoría:</span>
                            <div class="text-lg font-semibold text-gray-900">{{ ucfirst(str_replace(["_", "-"], " ", $service->category)) }}</div>
                        </div>
                    @endif

                    @if($service->icon)
                        <div class="mb-4">
                            <span class="text-sm font-medium text-gray-500">Especialidad:</span>
                            <div class="text-3xl">{{ $service->icon }}</div>
                        </div>
                    @endif

                    <div class="mb-4">
                        <span class="text-sm font-medium text-gray-500">Disponibilidad:</span>
                        <div class="text-lg font-semibold text-green-600">Consultar disponibilidad</div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="bg-green-600 text-white rounded-lg p-6 text-center">
                    <h3 class="text-xl font-bold mb-4">¿Interesado en este servicio?</h3>
                    <p class="mb-6">Contáctanos para recibir una cotización personalizada</p>
                    <a href="{{ route("contact.index") }}?service={{ $service->slug }}" 
                       class="bg-white text-green-600 px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors inline-block">
                        Solicitar Cotización
                    </a>
                </div>

                <!-- Información de Contacto -->
                <div class="bg-gray-50 rounded-lg p-6 mt-6">
                    <h4 class="font-bold text-gray-900 mb-3">Contacto Directo</h4>
                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex items-center">
                            <span class="mr-2">📞</span>
                            <span>951 308 4924</span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-2">✉️</span>
                            <span>info@proexna.com</span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-2">💬</span>
                            <span>WhatsApp disponible</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Servicios Relacionados -->
@if($relatedServices->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Servicios Relacionados</h2>
            <p class="text-lg text-gray-600">Otros servicios que podrían interesarte</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-{{ $relatedServices->count() > 2 ? "3" : $relatedServices->count() }} gap-8">
            @foreach($relatedServices as $related)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    @if($related->image_url)
                        <img src="{{ $related->image_url }}"
                             alt="{{ $related->title }}"
                             class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $related->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ $related->short_description }}</p>
                        <a href="{{ route("services.show", $related) }}" 
                           class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors inline-block">
                            Ver Detalles
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Call to Action Final -->
<section class="py-16 bg-green-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">¿Listo para comenzar?</h2>
        <p class="text-xl mb-8">
            Contáctanos hoy y descubre cómo podemos transformar tu espacio verde
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route("contact.index") }}" class="bg-white text-green-600 px-8 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors">
                Contactar Ahora
            </a>
            <a href="{{ route("services.index") }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-medium hover:bg-white hover:text-green-600 transition-colors">
                Ver Todos los Servicios
            </a>
        </div>
    </div>
</section>
@endsection
