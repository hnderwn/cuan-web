<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div
        x-data="{ sidebarOpen: false, sidebarFull: $persist(true) }"
        x-on:keydown.escape.window="sidebarOpen = false" {{-- Tambahan: tutup sidebar dengan tombol Esc --}}
        x-cloak
        class="flex h-screen bg-brand-lightest">
        <aside
            @click.away="sidebarOpen = false" {{-- Tambahan: tutup sidebar saat klik di luar area --}}
            :class="{ 'translate-x-0': sidebarOpen, 'w-64': sidebarFull, 'w-14': !sidebarFull }"
            class="fixed inset-y-0 left-0 z-30 flex-shrink-0 overflow-y-auto transition-all duration-500 transform bg-brand-darkest -translate-x-full lg:static lg:translate-x-0">

            @include('layouts.sidebar')
        </aside>

        <div x-show="sidebarOpen" class="fixed inset-0 z-20 bg-black opacity-50 lg:hidden" @click="sidebarOpen = false"></div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex items-center justify-between p-4 bg-white border-b">
                <div>
                    <button @click.stop="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                    <button @click.stop="sidebarFull = !sidebarFull" class="text-gray-500 focus:outline-none hidden lg:block">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H14M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>
                @if (isset($header))
                {{ $header }}
                @endif
                <div>
                    @include('layouts.navigation')
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-brand-lightest">
                @if (isset($header))
                @endif
                <div class="container mx-auto px-6 py-2">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>

</html>