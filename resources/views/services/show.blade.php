@extends("layouts.app")

@section("content")
<!-- Hero Section del Servicio -->
<div class="gradient-green text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl sm:text-5xl font-bold mb-4">{{ $service->title }}</h1>
            <p class="text-xl mb-6 max-w-3xl mx-auto">{{ $service->short_description ?: $service->description }}</p>
        </div>
    </div>
</div>

<!-- Galería de Imágenes -->
@if(count($service->all_images) > 0)
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Galería de Imágenes</h2>
        
        @if(count($service->all_images) > 1)
        <!-- Carrusel de múltiples imágenes -->
        <div class="relative" id="imageCarousel">
            <div class="overflow-hidden rounded-xl shadow-xl">
                @foreach($service->all_images as $index => $imageUrl)
                <div class="carousel-item {{ $index === 0 ? "active" : "" }} absolute inset-0 transition-opacity duration-500"
                     style="display: {{ $index === 0 ? "block" : "none" }};">
                    <img src="{{ $imageUrl }}" 
                         alt="{{ $service->title }} - Imagen {{ $index + 1 }}" 
                         class="w-full h-96 object-cover">
                </div>
                @endforeach
            </div>
            
            @if(count($service->all_images) > 1)
            <!-- Controles del carrusel -->
            <button onclick="prevImage()" 
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white p-3 rounded-full text-gray-800 shadow-lg transition-all duration-300">
                ←
            </button>
            
            <button onclick="nextImage()" 
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white p-3 rounded-full text-gray-800 shadow-lg transition-all duration-300">
                →
            </button>
            
            <!-- Indicadores -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                @foreach($service->all_images as $index => $imageUrl)
                <button onclick="goToImage({{ $index }})" 
                        class="w-3 h-3 rounded-full transition-all duration-300 {{ $index === 0 ? "bg-white" : "bg-white/50" }}"
                        data-index="{{ $index }}">
                </button>
                @endforeach
            </div>
            @endif
        </div>
        
        <!-- Miniaturas -->
        @if(count($service->all_images) > 1)
        <div class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-6 gap-4 mt-6">
            @foreach($service->all_images as $index => $imageUrl)
            <button onclick="goToImage({{ $index }})" 
                    class="thumbnail-btn aspect-square rounded-lg overflow-hidden border-2 transition-all duration-300 {{ $index === 0 ? "border-green-500" : "border-gray-200" }}"
                    data-index="{{ $index }}">
                <img src="{{ $imageUrl }}" 
                     alt="Miniatura {{ $index + 1 }}" 
                     class="w-full h-full object-cover">
            </button>
            @endforeach
        </div>
        @endif
        @else
        <!-- Imagen única -->
        <div class="max-w-4xl mx-auto">
            <img src="{{ $service->all_images[0] }}" 
                 alt="{{ $service->title }}" 
                 class="w-full h-96 object-cover rounded-xl shadow-xl">
        </div>
        @endif
    </div>
</section>
@endif

<!-- Información del Servicio -->
<section class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Descripción del Servicio</h3>
            <div class="prose prose-lg max-w-none">
                <p class="text-gray-600 leading-relaxed">{{ $service->description }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Servicios Relacionados -->
@if($relatedServices->count() > 0)
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Servicios Relacionados</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedServices as $relatedService)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                @if($relatedService->image_url)
                <div class="h-48 bg-cover bg-center" style="background-image: url({{ $relatedService->image_url }})"></div>
                @endif
                
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $relatedService->title }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($relatedService->short_description ?: $relatedService->description, 80) }}</p>
                    
                    <a href="{{ route("services.show", $relatedService) }}" 
                       class="text-green-600 hover:text-green-700 font-medium">
                        Ver más detalles →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Call to Action -->
<section class="py-16 bg-green-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">¿Te interesa este servicio?</h2>
        <p class="text-xl mb-8">Contáctanos para una cotización personalizada</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="tel:+529513084924" 
               class="bg-white text-green-600 hover:bg-gray-100 font-bold py-3 px-6 rounded-lg transition-colors duration-300">
                📞 Llamar Ahora
            </a>
            <a href="https://wa.me/529513084924?text=Hola, me interesa el servicio de {{ $service->title }}" target="_blank"
               class="border-2 border-white text-white hover:bg-white hover:text-green-600 font-bold py-3 px-6 rounded-lg transition-colors duration-300">
                💬 WhatsApp
            </a>
        </div>
    </div>
</section>

@if(count($service->all_images) > 1)
<script>
let currentImageIndex = 0;
let totalImages = {{ count($service->all_images) }};

function showImage(index) {
    // Ocultar todas las imágenes
    document.querySelectorAll(".carousel-item").forEach(item => {
        item.style.display = "none";
    });
    
    // Mostrar imagen actual
    document.querySelector(`[data-index="${index}"]`).parentElement.style.display = "block";
    
    // Actualizar indicadores
    document.querySelectorAll("[data-index]").forEach(indicator => {
        indicator.classList.remove("bg-white", "border-green-500");
        indicator.classList.add("bg-white/50", "border-gray-200");
    });
    
    // Activar indicador actual
    document.querySelector(`button[data-index="${index}"]`).classList.remove("bg-white/50", "border-gray-200");
    document.querySelector(`button[data-index="${index}"]`).classList.add("bg-white");
    document.querySelector(`.thumbnail-btn[data-index="${index}"]`).classList.add("border-green-500");
    document.querySelector(`.thumbnail-btn[data-index="${index}"]`).classList.remove("border-gray-200");
}

function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % totalImages;
    showImage(currentImageIndex);
}

function prevImage() {
    currentImageIndex = (currentImageIndex - 1 + totalImages) % totalImages;
    showImage(currentImageIndex);
}

function goToImage(index) {
    currentImageIndex = index;
    showImage(index);
}

// Auto avance cada 5 segundos
setInterval(nextImage, 5000);
</script>
@endif
@endsection
