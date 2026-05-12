@extends("layouts.app")

@section("content")
<!-- Hero Slider Mejorado -->
@if($heroSections->count() > 0)
<section class="relative overflow-hidden" style="height: 600px;" id="heroSlider">

    @foreach($heroSections as $index => $hero)
    <div class="hero-slide absolute inset-0 flex items-center justify-center transition-opacity duration-1000 ease-in-out {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
         data-slide="{{ $index }}"
         @if($hero->background_image_url || $hero->hero_image_url)
         style="background-image: url('{{ $hero->background_image_url ?: $hero->hero_image_url }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"
         @else
         style="background: linear-gradient(135deg, #16a34a 0%, #15803d 50%, #14532d 100%);"
         @endif>

        <!-- Overlay mejorado -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/50 via-black/30 to-black/50"></div>

        <!-- Contenido -->
        <div class="relative z-20 text-center max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6 text-4xl animate-bounce">
                    🌱
                </div>
            </div>

            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold mb-6 text-white">
                <span class="block drop-shadow-2xl">{{ $hero->title }}</span>
                @if($hero->subtitle)
                <span class="block text-green-200 mt-2 text-2xl sm:text-3xl md:text-4xl font-medium drop-shadow-lg">{{ $hero->subtitle }}</span>
                @endif
            </h1>

            <p class="text-lg sm:text-xl md:text-2xl mb-12 max-w-4xl mx-auto leading-relaxed text-white/95 drop-shadow-lg">
                {{ $hero->description }}
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="tel:+529513084924"
                   class="bg-white text-green-700 hover:bg-green-50 hover:text-green-800 font-bold py-4 px-8 rounded-xl transition-all duration-300 shadow-2xl hover:shadow-3xl transform hover:scale-105 hover:-translate-y-1">
                    📞 Llamar Ahora
                </a>

                <a href="https://wa.me/529513084924" target="_blank"
                   class="border-3 border-white text-white hover:bg-white hover:text-green-700 font-bold py-4 px-8 rounded-xl transition-all duration-300 shadow-2xl hover:shadow-3xl transform hover:scale-105 hover:-translate-y-1">
                    💬 WhatsApp
                </a>
            </div>
        </div>
    </div>
    @endforeach

    @if($heroSections->count() > 1)
    <!-- Navegación -->
    <button onclick="prevSlide()"
            class="absolute left-4 top-1/2 transform -translate-y-1/2 z-30 bg-white/20 hover:bg-white/40 backdrop-blur-sm p-3 rounded-full text-white text-2xl transition-all duration-300 hover:scale-110 shadow-lg">
        ←
    </button>

    <button onclick="nextSlide()"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 z-30 bg-white/20 hover:bg-white/40 backdrop-blur-sm p-3 rounded-full text-white text-2xl transition-all duration-300 hover:scale-110 shadow-lg">
        →
    </button>

    <!-- Indicadores -->
    <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 z-30 flex space-x-3">
        @foreach($heroSections as $index => $hero)
            <button onclick="goToSlide({{ $index }})"
                    class="slide-dot w-3 h-3 rounded-full transition-all duration-300 bg-white/50 hover:bg-white/80 {{ $index === 0 ? 'bg-white scale-125' : '' }}"
                    data-slide="{{ $index }}">
            </button>
        @endforeach
    </div>

    <!-- Indicador de progreso -->
    <div class="absolute bottom-0 left-0 w-full h-1 bg-black/20">
        <div id="progressBar" class="h-full bg-white transition-all duration-1000 ease-linear w-0"></div>
    </div>
    @endif
</section>

<script>
let currentSlide = 0;
let slides = null;
let dots = null;
let totalSlides = 0;
let autoAdvanceInterval = null;
let progressBar = null;
const autoAdvanceTime = 8000; // 8 segundos

function initSlider() {
    slides = document.querySelectorAll('.hero-slide');
    dots = document.querySelectorAll('.slide-dot');
    totalSlides = slides.length;
    progressBar = document.getElementById('progressBar');
    
    if (totalSlides > 1) {
        startAutoAdvance();
        addEventListeners();
    }
}

function showSlide(index) {
    if (index < 0 || index >= totalSlides) return;
    
    // Ocultar todos los slides
    slides.forEach((slide, i) => {
        slide.classList.remove('opacity-100', 'z-10');
        slide.classList.add('opacity-0', 'z-0');
    });
    
    // Resetear dots
    dots.forEach(dot => {
        dot.classList.remove('bg-white', 'scale-125');
        dot.classList.add('bg-white/50');
    });
    
    // Mostrar slide actual
    slides[index].classList.remove('opacity-0', 'z-0');
    slides[index].classList.add('opacity-100', 'z-10');
    
    // Activar dot
    if (dots[index]) {
        dots[index].classList.remove('bg-white/50');
        dots[index].classList.add('bg-white', 'scale-125');
    }
    
    currentSlide = index;
    resetProgress();
}

function nextSlide() {
    const next = (currentSlide + 1) % totalSlides;
    showSlide(next);
    restartAutoAdvance();
}

function prevSlide() {
    const prev = (currentSlide - 1 + totalSlides) % totalSlides;
    showSlide(prev);
    restartAutoAdvance();
}

function goToSlide(index) {
    showSlide(index);
    restartAutoAdvance();
}

function startAutoAdvance() {
    autoAdvanceInterval = setInterval(() => {
        const next = (currentSlide + 1) % totalSlides;
        showSlide(next);
    }, autoAdvanceTime);
    
    startProgress();
}

function restartAutoAdvance() {
    stopAutoAdvance();
    startAutoAdvance();
}

function stopAutoAdvance() {
    if (autoAdvanceInterval) {
        clearInterval(autoAdvanceInterval);
    }
}

function startProgress() {
    if (progressBar) {
        progressBar.style.transition = 'none';
        progressBar.style.width = '0%';
        
        setTimeout(() => {
            progressBar.style.transition = `width ${autoAdvanceTime}ms linear`;
            progressBar.style.width = '100%';
        }, 50);
    }
}

function resetProgress() {
    if (progressBar) {
        progressBar.style.transition = 'none';
        progressBar.style.width = '0%';
        setTimeout(() => {
            startProgress();
        }, 100);
    }
}

function addEventListeners() {
    const sliderSection = document.getElementById('heroSlider');
    if (sliderSection) {
        sliderSection.addEventListener('mouseenter', () => {
            stopAutoAdvance();
        });
        
        sliderSection.addEventListener('mouseleave', () => {
            startAutoAdvance();
        });
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    initSlider();
});
</script>
@endif

<!-- Services Section -->
@if($featuredServices->count() > 0)
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Nuestros Servicios Destacados</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Ofrecemos una amplia gama de servicios de jardinería y paisajismo para transformar tus espacios exteriores</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredServices as $service)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                @if($service->image_url)
                    <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="w-full h-48 object-cover">
                @endif

                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="text-2xl mr-3">{{ $service->icon_display }}</span>
                        <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded">{{ $service->category_name }}</span>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $service->title }}</h3>
                    <p class="text-gray-600 mb-4">{{ $service->short_description }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('services.index') }}" class="bg-green-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-green-700 transition-colors duration-300">
                Ver Todos los Servicios
            </a>
        </div>
    </div>
</section>
@endif

<!-- Contact CTA Section -->
<section class="py-20 bg-green-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">¿Listo para transformar tu jardín?</h2>
        <p class="text-lg mb-8 max-w-2xl mx-auto">Contáctanos hoy mismo y recibe una cotización gratuita para tu proyecto de jardinería</p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="tel:+529513084924" class="bg-white text-green-600 hover:bg-green-50 font-bold py-4 px-8 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                📞 Llamar Ahora
            </a>
            <a href="https://wa.me/529513084924" target="_blank" class="border-2 border-white text-white hover:bg-white hover:text-green-600 font-bold py-4 px-8 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                💬 WhatsApp
            </a>
            <a href="{{ route('contact.index') }}" class="border-2 border-white text-white hover:bg-white hover:text-green-600 font-bold py-4 px-8 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                📧 Contacto
            </a>
        </div>
    </div>
</section>
@endsection
