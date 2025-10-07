<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

    <div class="flex h-screen">

        <aside class="w-64 bg-white shadow-lg hidden md:flex flex-col transition-all duration-300">
            <div class="h-16 flex items-center justify-center border-b">
                <h1 class="text-2xl font-extrabold text-blue-600 tracking-wide">Dashboard</h1>
            </div>

            <nav class="flex-1 p-4 space-y-3">

                <a href="{{ route('books.index') }}" 
                   class="flex items-center px-4 py-2 rounded-lg transition-all duration-200 hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('books') ? 'bg-blue-100 text-blue-600 font-semibold shadow-inner' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M4 4.5A2.5 2.5 0 0 1 6.5 7H20V21H6.5A2.5 2.5 0 0 1 4 18.5z"/>
                    </svg>
                    Libros
                </a>

                <a href="{{ route('subscriptions.index') }}" 
                   class="flex items-center px-4 py-2 rounded-lg transition-all duration-200 hover:bg-green-50 hover:text-green-600 {{ request()->routeIs('subscriptions') ? 'bg-green-100 text-green-600 font-semibold shadow-inner' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <rect width="20" height="14" x="2" y="5" rx="2" ry="2"/>
                        <line x1="2" y1="10" x2="22" y2="10"/>
                    </svg>
                    Suscripciones
                </a>

                <a href="{{ route('loans.index') }}" 
                   class="flex items-center px-4 py-2 rounded-lg transition-all duration-200 hover:bg-yellow-50 hover:text-yellow-600 {{ request()->routeIs('loans') ? 'bg-yellow-100 text-yellow-600 font-semibold shadow-inner' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Préstamos
                </a>
            </nav>

            <div class="border-t p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="flex items-center w-full px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                        </svg>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto bg-gray-100">

            <header class="flex items-center justify-between bg-white shadow-md px-6 py-4 sticky top-0 z-10">
                <h2 class="text-lg font-semibold">Bienvenid@, {{ auth()->user()->name }}</h2>
                <button id="menuToggle" class="md:hidden text-gray-700 hover:text-blue-600 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </header>

            <section class="p-6">
                <div class="grid gap-6 md:grid-cols-3">

                    <div class="bg-white p-6 rounded-3xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-700">Libros</h3>
                                <p class="text-sm text-gray-500 mt-1">Gestiona el catálogo disponible</p>
                            </div>
                            <div class="bg-gradient-to-br from-blue-200 to-blue-100 p-3 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                    <path d="M4 4.5A2.5 2.5 0 0 1 6.5 7H20V21H6.5A2.5 2.5 0 0 1 4 18.5z"/>
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('books.index') }}" class="mt-4 inline-block text-blue-600 font-medium hover:underline">
                            Ver libros →
                        </a>
                    </div>

                    <div class="bg-white p-6 rounded-3xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-700">Suscripciones</h3>
                                <p class="text-sm text-gray-500 mt-1">Controla planes y usuarios activos</p>
                            </div>
                            <div class="bg-gradient-to-br from-green-200 to-green-100 p-3 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <rect width="20" height="14" x="2" y="5" rx="2" ry="2"/>
                                    <line x1="2" y1="10" x2="22" y2="10"/>
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('subscriptions.index') }}" class="mt-4 inline-block text-green-600 font-medium hover:underline">
                            Ver suscripciones →
                        </a>
                    </div>

                    <div class="bg-white p-6 rounded-3xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-700">Préstamos</h3>
                                <p class="text-sm text-gray-500 mt-1">Registra y gestiona préstamos de libros</p>
                            </div>
                            <div class="bg-gradient-to-br from-yellow-200 to-yellow-100 p-3 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('loans.index') }}" class="mt-4 inline-block text-yellow-600 font-medium hover:underline">
                            Ver préstamos →
                        </a>
                    </div>

                </div>
            </section>

        </main>

    </div>

    @vite(['resources/js/app.js'])
    @livewireScripts

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('aside');
        menuToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });
    </script>

</body>
</html>
