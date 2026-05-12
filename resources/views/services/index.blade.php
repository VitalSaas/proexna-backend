@extends("layouts.app")

@section("content")
<!-- Hero Section para Servicios -->
<div class="gradient-green text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6 text-4xl">
                🌿
            </div>
        </div>
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-6">
            Nuestros Servicios
        </h1>
        <p class="text-xl mb-8 max-w-3xl mx-auto">
            Especialistas en jardinería profesional. Servicios integrales desde mantenimientos generales hasta tratamientos especializados.
        </p>
    </div>
</div>

<!-- Servicios Destacados -->
@if($featuredServices->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Servicios Destacados</h2>
            <p class="text-lg text-gray-600">Los servicios más solicitados por nuestros clientes</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredServices as $service)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                @if($service->image_url)
                <div class="h-48 bg-cover bg-center" style="background-image: url({{ $service->image_url }})"></div>
                @else
                <div class="h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                    <span class="text-4xl">{{ $service->icon_display }}</span>
                </div>
                @endif
                
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $service->title }}</h3>
                    <p class="text-gray-600 mb-6">{{ $service->short_description ?: Str::limit($service->description, 100) }}</p>
                    
                    <div class="text-center">
                        <a href="{{ route("services.show", $service) }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition-colors duration-300 inline-block">
                            Ver más detalles
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Todos los Servicios -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Todos Nuestros Servicios</h2>
            <p class="text-lg text-gray-600">Soluciones completas para tu jardín</p>
        </div>
        
        <!-- Filtros por categoría -->
        @if($categories->count() > 0)
        <div class="flex flex-wrap justify-center gap-4 mb-12">
            <a href="{{ route("services.index") }}" 
               class="px-4 py-2 bg-green-600 text-white rounded-full hover:bg-green-700 transition-colors duration-300">
                Todos
            </a>
            @foreach($categories as $category)
            <a href="{{ route("services.category", $category) }}" 
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition-colors duration-300">
                {{ ucfirst($category) }}
            </a>
            @endforeach
        </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($services as $service)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                @if($service->image_url)
                <div class="h-40 bg-cover bg-center" style="background-image: url({{ $service->image_url }})"></div>
                @else
                <div class="h-40 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                    <span class="text-3xl">{{ $service->icon_display }}</span>
                </div>
                @endif
                
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $service->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($service->short_description ?: $service->description, 80) }}</p>
                    
                    <div class="text-center">
                        <a href="{{ route("services.show", $service) }}" 
                           class="text-green-600 hover:text-green-700 font-medium">
                            Ver más detalles →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-green-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">¿Te interesa alguno de nuestros servicios?</h2>
        <p class="text-xl mb-8">Contáctanos para una cotización gratuita y personalizada según tus necesidades</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="tel:+529513084924" 
               class="bg-white text-green-600 hover:bg-gray-100 font-bold py-3 px-6 rounded-lg transition-colors duration-300">
                📞 Llamar Ahora
            </a>
            <a href="https://wa.me/529513084924?text=Hola, me interesa cotizar un servicio de jardinería" target="_blank"
               class="border-2 border-white text-white hover:bg-white hover:text-green-600 font-bold py-3 px-6 rounded-lg transition-colors duration-300">
                💬 WhatsApp
            </a>
            <a href="{{ route("contact.index") }}" 
               class="border-2 border-white text-white hover:bg-white hover:text-green-600 font-bold py-3 px-6 rounded-lg transition-colors duration-300">
                ✉️ Contacto
            </a>
        </div>
    </div>
</section>
@endsection
