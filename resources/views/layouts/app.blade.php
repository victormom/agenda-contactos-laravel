<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Agenda de Contactos')</title>
    
    <!-- TailwindCSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    
    <!-- Navegación -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                            <i class="fas fa-address-book text-blue-600 text-2xl"></i>
                            <span class="text-xl font-bold text-gray-800">Agenda</span>
                        </a>
                    </div>
                    
                    <!-- Links de navegación -->
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-4">
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-100' }}">
                            <i class="fas fa-chart-pie mr-2"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('contacts.index') }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('contacts.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-100' }}">
                            <i class="fas fa-users mr-2"></i>
                            Contactos
                        </a>
                        <a href="{{ route('categories.index') }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('categories.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-100' }}">
                            <i class="fas fa-tags mr-2"></i>
                            Categorías
                        </a>
                    </div>
                </div>
                
                <!-- Botón agregar contacto -->
                <div class="flex items-center">
                    <a href="{{ route('contacts.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition">
                        <i class="fas fa-plus mr-2"></i>
                        Nuevo Contacto
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mensajes Flash -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg fade-in flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-green-800 hover:text-green-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg fade-in flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-red-800 hover:text-red-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Contenido principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Agenda de Contactos. Creado con Laravel y TailwindCSS.
            </p>
        </div>
    </footer>

    <!-- Scripts adicionales -->
    @stack('scripts')
</body>
</html>
