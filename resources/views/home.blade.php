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
            class="hidden md:block absolute left-4 top-1/2 transform -translate-y-1/2 z-30 bg-white/20 hover:bg-white/40 backdrop-blur-sm p-3 rounded-full text-white text-2xl transition-all duration-300 hover:scale-110 shadow-lg">
        ←
    </button>

    <button onclick="nextSlide()"
            class="hidden md:block absolute right-4 top-1/2 transform -translate-y-1/2 z-30 bg-white/20 hover:bg-white/40 backdrop-blur-sm p-3 rounded-full text-white text-2xl transition-all duration-300 hover:scale-110 shadow-lg">
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

<!-- Welcome Section -->
@if($welcomeSection)
<section class="relative py-20 md:py-28 bg-white overflow-hidden">
    <!-- Decoración de fondo -->
    <div aria-hidden="true" class="pointer-events-none absolute -top-24 -right-24 w-96 h-96 rounded-full bg-green-50 blur-3xl opacity-70"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -bottom-24 -left-24 w-80 h-80 rounded-full bg-green-100 blur-3xl opacity-60"></div>

    <div class="container mx-auto px-4 relative">
        <div class="grid md:grid-cols-2 gap-12 lg:gap-20 items-center max-w-6xl mx-auto">
            <!-- Imagen con marco decorativo -->
            <div class="order-2 md:order-1">
                <div class="relative">
                    <div aria-hidden="true" class="absolute -top-4 -left-4 w-full h-full rounded-2xl bg-green-600/10 hidden md:block"></div>
                    <div aria-hidden="true" class="absolute -bottom-4 -right-4 w-32 h-32 rounded-2xl border-4 border-green-600/30 hidden md:block"></div>

                    @if($welcomeSection->image_url)
                        <img src="{{ $welcomeSection->image_url }}"
                             alt="{{ $welcomeSection->image_alt ?: $welcomeSection->title }}"
                             class="relative w-full h-auto rounded-2xl shadow-2xl object-cover">
                    @else
                        <div class="relative w-full aspect-[4/3] bg-gradient-to-br from-green-400 to-green-700 rounded-2xl shadow-2xl flex items-center justify-center">
                            <span class="text-white text-7xl">🌿</span>
                        </div>
                    @endif

                    <!-- Etiqueta flotante -->
                    <div class="absolute -bottom-5 left-1/2 -translate-x-1/2 md:left-auto md:right-6 md:translate-x-0 bg-white rounded-full shadow-xl px-5 py-3 flex items-center gap-2 border border-green-100">
                        <span class="text-2xl">🌱</span>
                        <span class="text-sm font-semibold text-green-700 whitespace-nowrap">Profesionalismo en la naturaleza</span>
                    </div>
                </div>
            </div>

            <!-- Contenido -->
            <div class="order-1 md:order-2">
                <!-- Eyebrow -->
                <div class="inline-flex items-center gap-2 mb-4">
                    <span class="h-px w-8 bg-green-600"></span>
                    <span class="text-sm font-bold uppercase tracking-widest text-green-700">Bienvenidos a PROEXNA</span>
                </div>

                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    {{ $welcomeSection->title }}
                </h2>

                <!-- Barra de acento -->
                <div aria-hidden="true" class="w-16 h-1 bg-green-600 rounded-full mb-6"></div>

                @if($welcomeSection->content)
                    <div class="welcome-content max-w-none mb-8">
                        {!! $welcomeSection->content !!}
                    </div>
                @endif

                @if($welcomeSection->button_text && $welcomeSection->button_url)
                    <a href="{{ $welcomeSection->button_url }}"
                       class="inline-flex items-center gap-2 bg-green-600 text-white hover:bg-green-700 font-bold py-3 px-8 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        {{ $welcomeSection->button_text }}
                        <span aria-hidden="true" class="transition-transform group-hover:translate-x-1">→</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
    /* Tipografía para el contenido dinámico de bienvenida (3 párrafos) */
    .welcome-content p {
        color: #4b5563;
        line-height: 1.75;
        margin-bottom: 1.25rem;
    }
    /* Primer párrafo: protagonista */
    .welcome-content p:first-of-type {
        font-size: 1.2rem;
        line-height: 1.7;
        color: #1f2937;
        font-weight: 500;
        position: relative;
        padding-left: 1.25rem;
        border-left: 3px solid #16a34a;
    }
    /* Párrafos secundarios */
    .welcome-content p:not(:first-of-type) {
        font-size: 1.0625rem;
    }
    .welcome-content p:last-child {
        margin-bottom: 0;
    }
    .welcome-content strong {
        color: #15803d;
        font-weight: 700;
    }
    .welcome-content a {
        color: #16a34a;
        text-decoration: underline;
        text-underline-offset: 2px;
    }
    .welcome-content a:hover {
        color: #15803d;
    }
    .welcome-content ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 1.25rem;
    }
    .welcome-content ul li {
        position: relative;
        padding-left: 1.75rem;
        margin-bottom: 0.5rem;
        color: #4b5563;
    }
    .welcome-content ul li::before {
        content: "🌿";
        position: absolute;
        left: 0;
        top: 0;
    }
</style>
@endif

<!-- Why Choose Us Section -->
@if($whyChooseUs->count() > 0)
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">¿Por qué elegirnos?</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Lo que nos hace diferentes y por qué cientos de clientes ya confían en nosotros</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($whyChooseUs as $item)
            <div class="bg-white rounded-2xl p-8 shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                @if($item->icon)
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-green-100 text-3xl mb-5">
                        {{ $item->icon }}
                    </div>
                @endif
                <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $item->title }}</h3>
                @if($item->description)
                    <p class="text-gray-600 leading-relaxed">{{ $item->description }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Services Section -->
@if($featuredServices->count() > 0)
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Nuestros Servicios Destacados</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Ofrecemos una amplia gama de servicios de jardinería y paisajismo para transformar tus espacios exteriores</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredServices as $service)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 border border-gray-100">
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

<!-- Sectors Section -->
@if($sectors->count() > 0)
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Sectores que atendemos</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Soluciones especializadas para cada tipo de cliente</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
            @foreach($sectors as $sector)
            <div class="bg-white rounded-2xl p-6 text-center shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                @if($sector->image_url)
                    <img src="{{ $sector->image_url }}" alt="{{ $sector->title }}" class="w-full h-32 object-cover rounded-lg mb-4">
                @elseif($sector->icon)
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-4xl mb-4">
                        {{ $sector->icon }}
                    </div>
                @endif
                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $sector->title }}</h3>
                @if($sector->description)
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $sector->description }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Stats / Trust Strip -->
@if($stats->count() > 0)
<section class="py-10 md:py-12 bg-green-700 text-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 max-w-5xl mx-auto text-center">
            @foreach($stats as $stat)
            <div>
                @if($stat->icon)
                    <div class="text-3xl mb-2">{{ $stat->icon }}</div>
                @endif
                <div class="text-3xl md:text-4xl font-bold mb-1 leading-none">{{ $stat->value }}</div>
                <div class="text-sm md:text-base text-green-100">{{ $stat->label }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Projects Section -->
@if($featuredProjects->count() > 0)
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Proyectos Realizados</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Algunos de los trabajos que hemos completado para nuestros clientes</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredProjects as $project)
            <a href="{{ route('projects.show', $project) }}" class="block bg-gray-50 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col">
                @if($project->image_url)
                    <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                        <span class="text-white text-5xl">🌿</span>
                    </div>
                @endif

                <div class="p-6 flex flex-col flex-1">
                    @if($project->category)
                        <span class="self-start text-sm text-green-700 bg-green-100 px-2 py-1 rounded mb-3">
                            {{ \App\Models\Project::getCategories()[$project->category] ?? $project->category }}
                        </span>
                    @endif

                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $project->title }}</h3>

                    @if($project->short_description)
                        <p class="text-gray-600 mb-4">{{ $project->short_description }}</p>
                    @endif

                    <div class="mt-auto text-sm text-gray-500 space-y-1">
                        @if($project->location)
                            <div>📍 {{ $project->location }}</div>
                        @endif
                        @if($project->completed_at)
                            <div>📅 {{ $project->completed_at->format('m/Y') }}</div>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('projects.index') }}" class="bg-green-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-green-700 transition-colors duration-300">
                Ver Todos los Proyectos
            </a>
        </div>
    </div>
</section>
@endif

<!-- Testimonials Section -->
@if($testimonials->count() > 0)
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Lo que dicen nuestros clientes</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Testimonios reales de quienes confiaron en nosotros</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($testimonials as $testimonial)
            <article class="bg-white rounded-2xl p-8 shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100 flex flex-col">
                <div class="text-yellow-400 text-lg mb-4 tracking-wide">
                    {{ str_repeat('★', $testimonial->rating) }}<span class="text-gray-300">{{ str_repeat('★', 5 - $testimonial->rating) }}</span>
                </div>

                <blockquote class="text-gray-700 italic leading-relaxed mb-6 flex-1">
                    "{{ $testimonial->quote }}"
                </blockquote>

                <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                    @if($testimonial->image_url)
                        <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}" class="w-12 h-12 rounded-full object-cover">
                    @else
                        <div class="w-12 h-12 rounded-full bg-green-100 text-green-700 font-bold flex items-center justify-center text-lg">
                            {{ mb_strtoupper(mb_substr($testimonial->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <div class="font-bold text-gray-800">{{ $testimonial->name }}</div>
                        @if($testimonial->role || $testimonial->company)
                            <div class="text-sm text-gray-500">
                                {{ $testimonial->role }}{{ $testimonial->role && $testimonial->company ? ' · ' : '' }}{{ $testimonial->company }}
                            </div>
                        @endif
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Latest Blog Posts Section -->
@if($latestPosts->count() > 0)
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Últimas del blog</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Consejos, novedades y tips para mantener tu jardín en óptimas condiciones</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($latestPosts as $post)
            <a href="{{ route('blog.show', $post) }}" class="block bg-gray-50 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100 flex flex-col">
                @if($post->image_url)
                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                        <span class="text-white text-5xl">📝</span>
                    </div>
                @endif

                <div class="p-6 flex flex-col flex-1">
                    @if($post->category)
                        <span class="self-start text-xs text-green-700 bg-green-100 px-2 py-1 rounded mb-3 uppercase tracking-wide">
                            {{ \App\Models\Post::getCategories()[$post->category] ?? $post->category }}
                        </span>
                    @endif

                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">{{ $post->title }}</h3>

                    @if($post->excerpt)
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                    @endif

                    <div class="mt-auto flex items-center justify-between text-xs text-gray-500 pt-2 border-t border-gray-100">
                        <span>{{ $post->display_author }}</span>
                        @if($post->published_at)
                            <span>{{ $post->published_at->format('d/m/Y') }}</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('blog.index') }}" class="bg-green-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-green-700 transition-colors duration-300">
                Ver Todas las Publicaciones
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
