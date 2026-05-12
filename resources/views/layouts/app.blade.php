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
    <div class="bg-green-800 text-white py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center text-sm">
                <div class="flex items-center space-x-4">
                    <span>📞 <a href="tel:+529513084924" class="hover:text-green-200">951 308 4924</a></span>
                    <span>✉️ <a href="mailto:info@proexna.com" class="hover:text-green-200">info@proexna.com</a></span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="https://wa.me/529513084924" target="_blank" class="hover:text-green-200">💬 WhatsApp</a>
                    <span>🕒 Lun - Vie: 8:00 - 18:00</span>
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
                    <a href="{{ route("about") }}" class="text-gray-700 hover:text-green-600 transition-colors duration-300 font-medium">Nosotros</a>
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
                    <a href="{{ route("about") }}" class="block px-3 py-2 text-gray-700 hover:text-green-600 transition-colors duration-300">Nosotros</a>
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
                        <a href="#" class="text-2xl hover:text-green-400 transition-colors">📘</a>
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
                        <li>📍 Servicio a domicilio</li>
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
