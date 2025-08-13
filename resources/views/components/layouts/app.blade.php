<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <header class="bg-white shadow-sm"> <!-- Sfondo e ombreggiatura -->
        <div class="container mx-auto px-4 py-4"> <!-- Container centrato -->
            <div class="flex items-center justify-between"> <!-- Allineamento orizzontale -->
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                    <x-app-logo />
                </a>

                <!-- Menu (esempio con Flex) -->
                <nav class="hidden md:flex space-x-8"> <!-- Nascosto su mobile -->
                    <a href="#" class="text-gray-600 hover:text-indigo-500">Home</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-500">Servizi</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-500">Contatti</a>
                </nav>

                <!-- Bottone mobile (opzionale) -->
                <button class="md:hidden text-gray-500"> <!-- Visibile solo su mobile -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </header>
    <main class="container mx-auto px-4 py-8"> <!-- Centratura automatica e padding -->
        <h1 class="text-3xl font-bold mb-6">Titolo della Pagina</h1>
        <div class="bg-white rounded-lg p-6"> <!-- Card esempio -->
            <div>
                {{ $slot }}
            </div>
        </div>
    </main>

    @fluxScripts
</body>

</html>