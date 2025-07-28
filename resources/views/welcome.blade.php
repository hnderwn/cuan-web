<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cuan-Web</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans">
    <div class="bg-brand-lightest text-black/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

                <div class="flex justify-center mb-12">
                    <h1 class="text-4xl font-bold text-brand-darkest">Cuan-Web</h1>
                </div>

                <main>
                    <div class="text-center">
                        <h2 class="text-4xl md:text-5xl font-extrabold text-brand-darkest">
                            Atur Keuangan, Raih Impian.
                        </h2>
                        <p class="mt-4 text-lg text-gray-600">
                            Cuan-Web adalah aplikasi sederhana untuk membantumu melacak setiap pemasukan dan pengeluaran dengan mudah.
                        </p>

                        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                            @auth
                            <a href="{{ url('/dashboard') }}" class="inline-block w-full sm:w-auto rounded-lg bg-brand-dark px-6 py-3 text-base font-semibold text-white shadow-sm transition duration-150 hover:scale-105 active:scale-95">
                                Masuk ke Dashboard
                            </a>
                            @else
                            <a href="{{ route('register') }}" class="inline-block w-full sm:w-auto rounded-lg bg-brand-dark px-6 py-3 text-base font-semibold text-white shadow-sm transition duration-150 hover:scale-105 active:scale-95">
                                Mulai Sekarang
                            </a>
                            <a href="{{ route('login') }}" class="inline-block w-full sm:w-auto rounded-lg bg-white px-6 py-3 text-base font-semibold text-brand-dark shadow-sm ring-1 ring-inset ring-brand-dark transition duration-150 hover:bg-gray-50 hover:scale-105 active:scale-95">
                                Sudah Punya Akun? Masuk
                            </a>
                            @endauth
                        </div>
                    </div>
                </main>

                <footer class="py-16 text-center text-sm text-black/50">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </footer>
            </div>
        </div>
    </div>
</body>

</html>