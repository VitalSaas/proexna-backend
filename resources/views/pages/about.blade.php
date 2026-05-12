@extends("layouts.app")

@section("title", "Nosotros - PROEXNA")

@section("content")
<section class="bg-gradient-to-br from-green-600 to-green-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Acerca de PROEXNA</h1>
            <p class="text-xl max-w-3xl mx-auto">
                Más de 15 años creando espacios verdes excepcionales
            </p>
        </div>
    </div>
</section>

<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Profesionalismo en la Naturaleza
                </h2>
                <p class="text-lg text-gray-600 mb-6">
                    En PROEXNA somos especialistas en transformar espacios exteriores en verdaderos oasis naturales.
                    Nuestro equipo de profesionales combina experiencia, creatividad y pasión por la naturaleza.
                </p>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <span class="text-green-600 text-xl mr-3">✓</span>
                        <span class="text-gray-700">Equipo certificado de jardineros profesionales</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-green-600 text-xl mr-3">✓</span>
                        <span class="text-gray-700">Garantía en todos nuestros trabajos</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-green-600 text-xl mr-3">✓</span>
                        <span class="text-gray-700">Presupuestos sin compromiso</span>
                    </div>
                </div>
            </div>
            <div class="bg-green-50 rounded-lg p-8">
                <div class="text-6xl mb-4 text-center">🌳</div>
                <div class="grid grid-cols-2 gap-8 text-center">
                    <div>
                        <div class="text-3xl font-bold text-green-600 mb-2">500+</div>
                        <div class="text-gray-600">Jardines creados</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-green-600 mb-2">15+</div>
                        <div class="text-gray-600">Años experiencia</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-white text-center">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">¿Listo para trabajar con nosotros?</h2>
        <p class="text-lg text-gray-600 mb-8">
            Contáctanos hoy y descubre por qué somos la mejor opción para tu proyecto
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route(\"contact.index\") }}" class="btn-primary">Solicitar Cotización</a>
            <a href="{{ route(\"services.index\") }}" class="btn-secondary">Ver Servicios</a>
        </div>
    </div>
</section>
@endsection
