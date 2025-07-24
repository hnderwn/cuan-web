<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" class="mt-3 block w-full border-gray-300 rounded-lg 
                                          shadow-sm focus:border-brand-dark focus:ring-brand-dark 
                                          transition duration-300 focus:shadow-md focus:scale-[1.005]" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-3 block w-full border-gray-300 rounded-lg 
                                          shadow-sm focus:border-brand-dark focus:ring-brand-dark 
                                          transition duration-300 focus:shadow-md focus:scale-[1.005]" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-3 block w-full border-gray-300 rounded-lg 
                                          shadow-sm focus:border-brand-dark focus:ring-brand-dark 
                                          transition duration-300 focus:shadow-md focus:scale-[1.005]"
                type="password"
                name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="mt-3 block w-full border-gray-300 rounded-lg 
                                          shadow-sm focus:border-brand-dark focus:ring-brand-dark 
                                          transition duration-300 focus:shadow-md focus:scale-[1.005]"
                type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500
                      transition-all duration-200 ease-in-out hover:scale-105 active:scale-95 hover:text-brand-darkest"
                href="{{ route('login') }}">
                {{ __('Sudah terdaftar?') }}
            </a>

            <button type="submit" class="ms-4 bg-brand-dark hover:bg-brand-darkest text-white font-bold py-2 px-4 rounded-lg
                                         transition-transform duration-150 hover:scale-105 active:scale-95 active:shadow-inner">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</x-guest-layout>