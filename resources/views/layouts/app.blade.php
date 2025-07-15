<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-brand-lightest">
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-brand-dark lg:translate-x-0 lg:static lg:inset-0">
            @include('layouts.sidebar')
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden bg-brand-darkest">
            <header class="flex items-center justify-between p-4">
                <button @click.stop="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6H20M4 12H20M4 18H11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>

                {{-- Spacer untuk mendorong dropdown ke kanan --}}
                <div class="flex-grow"></div>

                <div>
                    @include('layouts.navigation')
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-brand-darkest   px-2">
                <div class="bg-brand-lightest container mx-auto px-6 py-8 rounded-3xl">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>

</html>