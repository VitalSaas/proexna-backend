<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield("title", "PROEXNA - Profesionalismo en la Naturaleza")</title>
    <meta name="description" content="@yield("description", "Especialistas en jardinería profesional. Servicios integrales desde mantenimientos generales hasta tratamientos especializados por invasión de hongos.")">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom CSS -->
    <style>
        [x-cloak] { display: none !important; }
        
        .gradient-green {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%);
        }
        
        .gradient-overlay {
            background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.7));
        }
        
        .hero-section {
            min-height: 600px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-float-delayed {
            animation: float 6s ease-in-out infinite;
            animation-delay: 2s;
        }
        
        .btn-primary {
            @apply bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg;
        }
        
        .btn-secondary {
            @apply border-2 border-green-600 text-green-600 hover:bg-green-600 hover:text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105;
        }
        
        .card {
            @apply bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden;
        }
    </style>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: "#f0fdf4",
                            100: "#dcfce7",
                            200: "#bbf7d0",
                            300: "#86efac",
                            400: "#4ade80",
                            500: "#22c55e",
                            600: "#16a34a",
                            700: "#15803d",
                            800: "#166534",
                            900: "#14532d"
                        }
                    }
                }
            }
        }
    </script>
    
    @stack("styles")
</head>
<body class="bg-gray-50 text-gray-900">
    <!-- Top Contact Bar -->
    <div class="bg-green-800 text-white text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center md:justify-between gap-x-5 sm:gap-x-6 gap-y-1 py-2 flex-wrap">
                <!-- Contactos directos -->
                <div class="flex items-center gap-x-5 sm:gap-x-6">
                    <a href="tel:+529513084924"
                       class="inline-flex items-center gap-2 hover:text-green-200 transition-colors"
                       aria-label="Llamar al 951 308 4924">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h2.28a2 2 0 011.94 1.515l.7 2.8a2 2 0 01-.45 1.9l-1.27 1.27a16 16 0 006.586 6.586l1.27-1.27a2 2 0 011.9-.45l2.8.7A2 2 0 0121 18.72V21a2 2 0 01-2 2h-1C9.716 23 1 14.284 1 4V3" />
                        </svg>
                        <span class="font-medium">951 308 4924</span>
                    </a>

                    <a href="mailto:info@proexna.com"
                       class="inline-flex items-center gap-2 hover:text-green-200 transition-colors"
                       aria-label="Enviar correo a info@proexna.com">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="hidden md:inline">info@proexna.com</span>
                        <span class="md:hidden">Correo</span>
                    </a>

                    <a href="https://wa.me/529513084924"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 hover:text-green-200 transition-colors"
                       aria-label="WhatsApp">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.247-.694.247-1.289.173-1.413z"/>
                        </svg>
                        <span class="hidden sm:inline">WhatsApp</span>
                    </a>
                </div>

                <!-- Horario -->
                <div class="hidden md:inline-flex items-center gap-2 text-green-100">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Lun&nbsp;–&nbsp;Vie: 8:00&nbsp;–&nbsp;18:00</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route("home") }}" class="flex items-center space-x-3">
                        <span class="text-3xl">🌱</span>
                        <div>
                            <h1 class="text-2xl font-bold text-green-600">PROEXNA</h1>
                            <p class="text-xs text-gray-600">Profesionalismo en la naturaleza</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route("home") }}" class="text-gray-700 hover:text-green-600 transition-colors duration-300 font-medium">Inicio</a>
                    <a href="{{ route("services.index") }}" class="text-gray-700 hover:text-green-600 transition-colors duration-300 font-medium">Servicios</a>
                    <a href="{{ route("projects.index") }}" class="text-gray-700 hover:text-green-600 transition-colors duration-300 font-medium">Proyectos</a>
                    <a href="{{ route("blog.index") }}" class="text-gray-700 hover:text-green-600 transition-colors duration-300 font-medium">Blog</a>
                    <a href="{{ route("about") }}" class="text-gray-700 hover:text-green-600 transition-colors duration-300 font-medium">Nosotros</a>
                    <a href="{{ route("careers.index") }}" class="text-gray-700 hover:text-green-600 transition-colors duration-300 font-medium">Trabaja con Nosotros</a>
                    <a href="{{ route("contact.index") }}" class="text-gray-700 hover:text-green-600 transition-colors duration-300 font-medium">Contacto</a>
                    <a href="tel:+529513084924" class="btn-primary">Llamar Ahora</a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="open = !open" class="text-gray-700 hover:text-green-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div x-show="open" x-cloak class="md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t">
                    <a href="{{ route("home") }}" class="block px-3 py-2 text-gray-700 hover:text-green-600 transition-colors duration-300">Inicio</a>
                    <a href="{{ route("services.index") }}" class="block px-3 py-2 text-gray-700 hover:text-green-600 transition-colors duration-300">Servicios</a>
                    <a href="{{ route("projects.index") }}" class="block px-3 py-2 text-gray-700 hover:text-green-600 transition-colors duration-300">Proyectos</a>
                    <a href="{{ route("blog.index") }}" class="block px-3 py-2 text-gray-700 hover:text-green-600 transition-colors duration-300">Blog</a>
                    <a href="{{ route("about") }}" class="block px-3 py-2 text-gray-700 hover:text-green-600 transition-colors duration-300">Nosotros</a>
                    <a href="{{ route("careers.index") }}" class="block px-3 py-2 text-gray-700 hover:text-green-600 transition-colors duration-300">Trabaja con Nosotros</a>
                    <a href="{{ route("contact.index") }}" class="block px-3 py-2 text-gray-700 hover:text-green-600 transition-colors duration-300">Contacto</a>
                    <a href="tel:+529513084924" class="block mx-3 mt-3 btn-primary text-center">Llamar Ahora</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield("content")
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="text-3xl">🌱</span>
                        <h3 class="text-2xl font-bold">PROEXNA</h3>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Profesionalismo y experiencia en la naturaleza. Servicios integrales de jardinería profesional,
                        desde mantenimientos generales hasta tratamientos especializados por invasión de hongos.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/proexna.jardineria" target="_blank" rel="noopener" aria-label="Facebook" class="hover:text-green-400 transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-2xl hover:text-green-400 transition-colors">📷</a>
                        <a href="#" class="text-2xl hover:text-green-400 transition-colors">🐦</a>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Servicios</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route("services.category", "mantenimiento") }}" class="hover:text-white transition-colors">Mantenimiento</a></li>
                        <li><a href="{{ route("services.category", "diseno") }}" class="hover:text-white transition-colors">Diseño de Jardines</a></li>
                        <li><a href="{{ route("services.category", "instalacion") }}" class="hover:text-white transition-colors">Instalación</a></li>
                        <li><a href="{{ route("services.category", "tratamiento") }}" class="hover:text-white transition-colors">Tratamientos</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>
                            <a href="tel:+529513084924" class="hover:text-white transition-colors">
                                📞 951 308 4924
                            </a>
                        </li>
                        <li>
                            <a href="mailto:info@proexna.com" class="hover:text-white transition-colors">
                                ✉️ info@proexna.com
                            </a>
                        </li>
                        <li class="text-green-400 font-semibold">PROEXNA CERCA DE TI</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date("Y") }} PROEXNA - Profesionalismo y Experiencia en la Naturaleza. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <a href="https://wa.me/529513084924?text=¡Hola PROEXNA! 🌱 Me interesa conocer más sobre sus servicios profesionales de jardinería."
           target="_blank"
           class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 flex items-center space-x-2">
            <span class="text-2xl">💬</span>
            <span class="hidden sm:inline font-medium">WhatsApp</span>
        </a>
    </div>

    @stack("scripts")
</body>
</html>
