@extends("layouts.app")

@section("title", "Nosotros - PROEXNA")

@section("content")
<section class="bg-gradient-to-br from-green-600 to-green-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Acerca de PROEXNA</h1>
            <p class="text-xl max-w-3xl mx-auto">
                Más de 15 años transformando espacios verdes con profesionalismo y pasión por la naturaleza
            </p>
        </div>
    </div>
</section>

<!-- Historia y Misión -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Profesionalismo en la Naturaleza
                </h2>
                <p class="text-lg text-gray-600 mb-6">
                    En PROEXNA somos especialistas en transformar espacios exteriores en verdaderos oasis naturales.
                    Nuestro equipo de profesionales combina experiencia, creatividad y pasión por la naturaleza para
                    ofrecer servicios integrales de jardinería y paisajismo.
                </p>
                <p class="text-lg text-gray-600 mb-6">
                    Desde nuestros inicios, nos hemos especializado en el mantenimiento de jardines, control de plagas
                    y hongos, diseño paisajístico y todos los servicios necesarios para mantener espacios verdes
                    saludables y hermosos.
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
                        <span class="text-gray-700">Presupuestos personalizados sin compromiso</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-green-600 text-xl mr-3">✓</span>
                        <span class="text-gray-700">Atención especializada en tratamiento de hongos</span>
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
                    <div>
                        <div class="text-3xl font-bold text-green-600 mb-2">98%</div>
                        <div class="text-gray-600">Clientes satisfechos</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-green-600 mb-2">24/7</div>
                        <div class="text-gray-600">Soporte disponible</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Valores y Misión -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Nuestros Valores</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Estos principios guían cada uno de nuestros proyectos y nos permiten ofrecer 
                servicios de jardinería de la más alta calidad.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl text-white">🌿</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Sostenibilidad</h3>
                <p class="text-gray-600">
                    Utilizamos prácticas ecológicas y productos amigables con el medio ambiente 
                    para preservar la naturaleza.
                </p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl text-white">⚡</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Innovación</h3>
                <p class="text-gray-600">
                    Incorporamos las últimas técnicas y tecnologías en jardinería para 
                    ofrecer resultados excepcionales.
                </p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl text-white">🏆</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Excelencia</h3>
                <p class="text-gray-600">
                    Cada proyecto es una oportunidad para superar expectativas y 
                    demostrar nuestro compromiso con la calidad.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Especialidades -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Nuestras Especialidades</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Áreas en las que destacamos y que nos convierten en líderes del sector
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white rounded-lg shadow-lg p-6 text-center border-t-4 border-green-600">
                <div class="text-4xl mb-4">🛡️</div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Control de Hongos</h3>
                <p class="text-sm text-gray-600">Tratamientos especializados contra invasión de hongos y enfermedades</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-6 text-center border-t-4 border-green-600">
                <div class="text-4xl mb-4">✂️</div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Poda Artística</h3>
                <p class="text-sm text-gray-600">Poda profesional que combina salud de plantas con diseño estético</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-6 text-center border-t-4 border-green-600">
                <div class="text-4xl mb-4">🎨</div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Diseño Paisajístico</h3>
                <p class="text-sm text-gray-600">Creación de espacios verdes únicos adaptados a tus necesidades</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-6 text-center border-t-4 border-green-600">
                <div class="text-4xl mb-4">🏢</div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Jardines Corporativos</h3>
                <p class="text-sm text-gray-600">Mantenimiento profesional para espacios comerciales y oficinas</p>
            </div>
        </div>
    </div>
</section>

<!-- Compromiso -->
<section class="py-20 bg-green-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Nuestro Compromiso</h2>
        <p class="text-xl mb-8 opacity-90">
            En PROEXNA nos comprometemos a transformar tu visión en realidad, 
            creando espacios verdes que no solo sean hermosos, sino también sostenibles y funcionales.
        </p>
        <div class="bg-white bg-opacity-20 rounded-lg p-8 backdrop-blur-sm">
            <p class="text-lg mb-6">
                "Cada jardín es una obra de arte viva que florece con el cuidado adecuado. 
                Nuestro equipo se dedica a crear y mantener espacios que inspiren y conecten 
                a las personas con la naturaleza."
            </p>
            <div class="text-sm opacity-75">
                - Equipo PROEXNA
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-white text-center">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">¿Listo para trabajar con nosotros?</h2>
        <p class="text-lg text-gray-600 mb-8">
            Contáctanos hoy y descubre por qué somos la mejor opción para tu proyecto de jardinería
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route("contact.index") }}" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition-colors font-medium">
                Solicitar Cotización
            </a>
            <a href="{{ route("services.index") }}" class="border-2 border-green-600 text-green-600 px-8 py-3 rounded-lg hover:bg-green-600 hover:text-white transition-colors font-medium">
                Ver Servicios
            </a>
        </div>
    </div>
</section>
@endsection
