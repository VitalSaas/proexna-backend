'use client'

import { useState, useEffect } from 'react'
import { useHeroSections } from '@/hooks/useHeroSections'
import { HeroSection } from '@/types/api'

interface SlideData {
  id: number
  title: string
  subtitle: string
  description: string
  backgroundImage: string
  buttonText: string
  buttonSecondaryText: string
}

// Función para transformar datos de la API a formato del slider
const transformHeroSectionToSlide = (heroSection: HeroSection): SlideData => ({
  id: heroSection.id,
  title: heroSection.title,
  subtitle: heroSection.subtitle || '',
  description: heroSection.description || '',
  backgroundImage: generateBackgroundStyle(heroSection),
  buttonText: heroSection.buttonText,
  buttonSecondaryText: heroSection.buttonSecondaryText,
})

// Función para generar el estilo de fondo
const generateBackgroundStyle = (heroSection: HeroSection): string => {
  // Si hay una imagen, usarla con gradiente si existe
  if (heroSection.imageUrl) {
    if (heroSection.gradientOverlay) {
      return `${heroSection.gradientOverlay}, url('${heroSection.imageUrl}')`
    }
    return `url('${heroSection.imageUrl}')`
  }

  // Si hay gradiente sin imagen
  if (heroSection.gradientOverlay) {
    return heroSection.gradientOverlay
  }

  // Si usa backgroundImage del campo calculado
  if (heroSection.backgroundImage) {
    return heroSection.backgroundImage
  }

  // Fallback por defecto
  return 'linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%)'
}

// Datos de fallback en caso de error o carga
const fallbackSlides: SlideData[] = [
  {
    id: 1,
    title: "PROEXNA",
    subtitle: "Profesionalismo en la naturaleza",
    description: "Especialistas en jardinería profesional. Ofrecemos servicios integrales desde mantenimientos generales hasta tratamientos especializados por invasión de hongos.",
    backgroundImage: "linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%)",
    buttonText: "951 308 4924",
    buttonSecondaryText: "WhatsApp"
  }
]

export default function HeroSlider() {
  const { heroSections, loading, error } = useHeroSections()
  const [currentSlide, setCurrentSlide] = useState(0)
  const [isAutoPlaying, setIsAutoPlaying] = useState(true)

  // Transformar datos de la API o usar fallback
  const slides: SlideData[] = error || heroSections.length === 0
    ? fallbackSlides
    : heroSections.map(transformHeroSectionToSlide)

  useEffect(() => {
    if (!isAutoPlaying) return

    const interval = setInterval(() => {
      setCurrentSlide((prev) => (prev + 1) % slides.length)
    }, 5000) // Cambiar cada 5 segundos

    return () => clearInterval(interval)
  }, [isAutoPlaying])

  const goToSlide = (index: number) => {
    setCurrentSlide(index)
    setIsAutoPlaying(false)
    // Reanudar autoplay después de 10 segundos
    setTimeout(() => setIsAutoPlaying(true), 10000)
  }

  const goToPrevious = () => {
    setCurrentSlide((prev) => (prev - 1 + slides.length) % slides.length)
    setIsAutoPlaying(false)
    setTimeout(() => setIsAutoPlaying(true), 10000)
  }

  const goToNext = () => {
    setCurrentSlide((prev) => (prev + 1) % slides.length)
    setIsAutoPlaying(false)
    setTimeout(() => setIsAutoPlaying(true), 10000)
  }

  const currentSlideData = slides[currentSlide]

  // Mostrar indicador de carga
  if (loading) {
    return (
      <section className="relative h-screen overflow-hidden flex items-center justify-center" style={{ paddingTop: '4rem' }}>
        <div
          className="absolute inset-0"
          style={{ background: 'linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%)' }}
        >
          <div className="absolute inset-0 bg-black/20"></div>
        </div>
        <div className="relative z-10 text-center">
          <div className="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6 animate-pulse">
            <span className="text-4xl">🌱</span>
          </div>
          <h2 className="text-2xl text-white font-semibold">Cargando...</h2>
        </div>
      </section>
    )
  }

  return (
    <section className="relative h-screen overflow-hidden" style={{ paddingTop: '4rem' }}>
      {/* Slider Container */}
      <div className="absolute inset-0">
        {slides.map((slide, index) => (
          <div
            key={slide.id}
            className={`absolute inset-0 transition-all duration-1000 ease-in-out transform ${
              index === currentSlide
                ? 'opacity-100 translate-x-0'
                : index < currentSlide
                ? 'opacity-0 -translate-x-full'
                : 'opacity-0 translate-x-full'
            }`}
            style={{ background: slide.backgroundImage }}
          >
            {/* Overlay Pattern */}
            <div className="absolute inset-0 bg-black/20"></div>
            <div className="absolute inset-0 bg-gradient-to-br from-white/10 via-transparent to-black/30"></div>

            {/* Decorative Elements */}
            <div className="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-3xl"></div>
            <div className="absolute bottom-32 right-20 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
            <div className="absolute top-1/3 right-1/4 w-24 h-24 bg-yellow-300/20 rounded-full blur-2xl"></div>
          </div>
        ))}
      </div>

      {/* Content */}
      <div className="relative z-10 h-full flex items-center">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
          <div className="text-center">
            <div className="mb-8">
              {/* Animated Icon */}
              <div className="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6 animate-pulse">
                <span className="text-4xl">🌱</span>
              </div>
            </div>

            <h1 className="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 animate-fade-in">
              <span className="block transform transition-all duration-700 delay-200">
                {currentSlideData.title}
              </span>
              <span className="block text-green-100 transform transition-all duration-700 delay-400">
                {currentSlideData.subtitle}
              </span>
            </h1>

            <p className="text-lg md:text-xl text-green-50 mb-12 max-w-3xl mx-auto transform transition-all duration-700 delay-600 leading-relaxed">
              {currentSlideData.description}
            </p>

            <div className="flex flex-col sm:flex-row gap-4 justify-center transform transition-all duration-700 delay-800">
              <button className="group bg-white text-green-600 hover:bg-green-50 font-bold py-4 px-8 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <span className="flex items-center justify-center">
                  {currentSlideData.buttonText}
                  <span className="ml-2 group-hover:translate-x-1 transition-transform duration-300">→</span>
                </span>
              </button>
              <button className="group border-2 border-white text-white hover:bg-white hover:text-green-600 font-bold py-4 px-8 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <span className="flex items-center justify-center">
                  {currentSlideData.buttonSecondaryText}
                  <span className="ml-2 group-hover:translate-x-1 transition-transform duration-300">→</span>
                </span>
              </button>
            </div>
          </div>
        </div>
      </div>

      {/* Navigation Arrows */}
      <button
        onClick={goToPrevious}
        className="absolute left-4 top-1/2 -translate-y-1/2 z-20 group bg-white/20 hover:bg-white/30 backdrop-blur-sm p-3 rounded-full transition-all duration-300"
        aria-label="Slide anterior"
      >
        <span className="text-white text-xl group-hover:scale-110 transition-transform duration-300">←</span>
      </button>

      <button
        onClick={goToNext}
        className="absolute right-4 top-1/2 -translate-y-1/2 z-20 group bg-white/20 hover:bg-white/30 backdrop-blur-sm p-3 rounded-full transition-all duration-300"
        aria-label="Siguiente slide"
      >
        <span className="text-white text-xl group-hover:scale-110 transition-transform duration-300">→</span>
      </button>

      {/* Dots Indicator */}
      <div className="absolute bottom-8 left-1/2 -translate-x-1/2 z-20">
        <div className="flex space-x-3">
          {slides.map((_, index) => (
            <button
              key={index}
              onClick={() => goToSlide(index)}
              className={`w-3 h-3 rounded-full transition-all duration-300 ${
                index === currentSlide
                  ? 'bg-white scale-125'
                  : 'bg-white/50 hover:bg-white/80'
              }`}
              aria-label={`Ir al slide ${index + 1}`}
            />
          ))}
        </div>
      </div>

      {/* Progress Bar */}
      <div className="absolute bottom-0 left-0 right-0 h-1 bg-white/20 z-20">
        <div
          className="h-full bg-white transition-all duration-300 ease-linear"
          style={{
            width: isAutoPlaying ? '100%' : '0%',
            animation: isAutoPlaying ? `progress 5000ms linear infinite` : 'none'
          }}
        />
      </div>

      {/* Floating Elements */}
      <div className="absolute top-1/4 left-1/4 animate-float">
        <div className="w-4 h-4 bg-yellow-300/30 rounded-full"></div>
      </div>
      <div className="absolute top-3/4 right-1/3 animate-float-delayed">
        <div className="w-6 h-6 bg-green-300/40 rounded-full"></div>
      </div>
      <div className="absolute bottom-1/3 left-1/6 animate-float">
        <div className="w-3 h-3 bg-white/40 rounded-full"></div>
      </div>
    </section>
  )
}