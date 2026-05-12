@extends("layouts.app")

@section("title", "Contacto - PROEXNA")

@section("content")
<!-- Hero Section -->
<section class="bg-gradient-to-br from-green-600 to-green-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Contáctanos</h1>
            <p class="text-xl max-w-3xl mx-auto">
                ¿Listo para transformar tu jardín? Ponte en contacto con nosotros y recibe una consulta gratuita
            </p>
        </div>
    </div>
</section>

<!-- Contact Content -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Information -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Información de Contacto</h2>
                
                <div class="space-y-6 mb-8">
                    <div class="flex items-start">
                        <span class="text-3xl mr-4">📍</span>
                        <div>
                            <h4 class="font-semibold text-gray-900">Área de Servicio</h4>
                            <p class="text-gray-600">Servicio a domicilio en toda la región</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <span class="text-3xl mr-4">📞</span>
                        <div>
                            <h4 class="font-semibold text-gray-900">Teléfono</h4>
                            <div class="flex flex-col space-y-2">
                                <a href="tel:+529513084924" 
                                   class="text-green-600 hover:text-green-700 font-medium text-lg transition-colors">
                                    951 308 4924
                                </a>
                                <a href="https://wa.me/529513084924?text=¡Hola PROEXNA! 🌱 Me interesa recibir información sobre sus servicios profesionales de jardinería."
                                   target="_blank"
                                   class="inline-flex items-center space-x-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300 transform hover:scale-105 w-fit">
                                    <span>💬</span>
                                    <span>WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <span class="text-3xl mr-4">✉️</span>
                        <div>
                            <h4 class="font-semibold text-gray-900">Email</h4>
                            <a href="mailto:info@proexna.com" 
                               class="text-green-600 hover:text-green-700 transition-colors">
                                info@proexna.com
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <span class="text-3xl mr-4">🕒</span>
                        <div>
                            <h4 class="font-semibold text-gray-900">Horario de Atención</h4>
                            <p class="text-gray-600">Lunes - Viernes: 8:00 - 18:00<br>Sábado: 9:00 - 14:00</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Contact Buttons -->
                <div class="bg-green-50 p-6 rounded-lg border border-green-100">
                    <h4 class="font-semibold text-gray-900 mb-4">Contacto Rápido</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="tel:+529513084924" 
                           class="flex items-center justify-center space-x-2 bg-blue-500 hover:bg-blue-600 text-white py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105">
                            <span>📞</span>
                            <span>Llamar</span>
                        </a>
                        <a href="https://wa.me/529513084924?text=¡Hola PROEXNA! 🌱 Necesito una cotización para mi jardín."
                           target="_blank"
                           class="flex items-center justify-center space-x-2 bg-green-500 hover:bg-green-600 text-white py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105">
                            <span>💬</span>
                            <span>WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Envíanos un Mensaje</h3>
                
                @if(session("success"))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <span class="text-green-600 text-xl mr-3">✅</span>
                            <div>
                                <h4 class="text-green-800 font-semibold">¡Mensaje enviado exitosamente!</h4>
                                <p class="text-green-700 text-sm">{{ session("success") }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <span class="text-red-600 text-xl mr-3">❌</span>
                            <div>
                                <h4 class="text-red-800 font-semibold">Error en el formulario</h4>
                                <ul class="text-red-700 text-sm mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route("contact.store") }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre completo *
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               required 
                               value="{{ old("name") }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                               placeholder="Tu nombre">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email *
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required 
                               value="{{ old("email") }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                               placeholder="tu@email.com">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Teléfono
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old("phone") }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                               placeholder="+52 951 123 4567">
                    </div>

                    <div>
                        <label for="service_interest" class="block text-sm font-medium text-gray-700 mb-2">
                            Servicio de interés
                        </label>
                        <select id="service_interest" 
                                name="service_interest"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                            <option value="">Seleccionar servicio (opcional)</option>
                            @foreach($services as $key => $name)
                                <option value="{{ $key }}" {{ old("service_interest") == $key ? "selected" : "" }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            Asunto
                        </label>
                        <input type="text" 
                               id="subject" 
                               name="subject" 
                               value="{{ old("subject") }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                               placeholder="Asunto del mensaje">
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Mensaje *
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  required 
                                  rows="5"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                                  placeholder="Cuéntanos sobre tu proyecto de jardín...">{{ old("message") }}</textarea>
                    </div>

                    <button type="submit" class="btn-primary w-full">
                        Enviar Mensaje
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Additional Info -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">¿Por qué elegir PROEXNA?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <span class="text-5xl block mb-4">🏆</span>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Experiencia Comprobada</h3>
                <p class="text-gray-600">Más de 15 años transformando espacios verdes</p>
            </div>
            <div>
                <span class="text-5xl block mb-4">✅</span>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Garantía Total</h3>
                <p class="text-gray-600">Garantizamos la calidad de todos nuestros trabajos</p>
            </div>
            <div>
                <span class="text-5xl block mb-4">🌱</span>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Profesionalismo</h3>
                <p class="text-gray-600">Equipo certificado y herramientas profesionales</p>
            </div>
        </div>
    </div>
</section>
@endsection
