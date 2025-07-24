<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-3 block w-full border-gray-300 rounded-lg 
                                          shadow-sm focus:border-brand-dark focus:ring-brand-dark 
                                          transition duration-300 focus:shadow-md focus:scale-[1.005]" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="mt-3 block w-full border-gray-300 rounded-lg 
                                          shadow-sm focus:border-brand-dark focus:ring-brand-dark 
                                          transition duration-300 focus:shadow-md focus:scale-[1.005]"
                type="password"
                name="password"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-brand-dark shadow-sm focus:ring-brand-medium" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
            </label>
        </div>


        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500
                      transition-all duration-200 ease-in-out hover:scale-105 active:scale-95 hover:text-brand-darkest" href="{{ route('password.request') }}">
                {{ __('Lupa password?') }}
            </a>
            @endif

            <button type="submit" class="ms-3 bg-brand-dark hover:bg-brand-darkest text-white font-bold py-2 px-4 rounded-lg transition-transform duration-150 hover:scale-105 active:scale-95">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</x-guest-layout>