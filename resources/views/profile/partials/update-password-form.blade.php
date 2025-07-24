<section x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Perbarui Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="relative">
            <x-input-label for="current_password" :value="__('Password Saat Ini')" />
            <input id="current_password" name="current_password" :type="showCurrent ? 'text' : 'password'" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-brand-medium focus:border-brand-dark transition duration-150" autocomplete="current-password">
            <div class="absolute inset-y-0 right-0 top-6 pr-3 flex items-center text-sm leading-5">
                <button type="button" @click="showCurrent = !showCurrent"
                    class="text-gray-500 relative h-5 w-5 
                       transition duration-200 
                       hover:text-brand-medium hover:scale-110 
                       active:text-brand-dark">

                    <svg x-show="!showCurrent"
                        x-transition:enter="transition ease-in-out duration-500"
                        x-transition:enter-start="opacity-0 scale-50"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in-out duration-500 absolute top-0"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-50"
                        class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>

                    <svg x-show="showCurrent" x-cloak
                        x-transition:enter="transition ease-in-out duration-500"
                        x-transition:enter-start="opacity-0 scale-50"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in-out duration-500 absolute top-0"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-50"
                        class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 .844-2.682 2.91-4.942 5.542-6.175M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0A10.025 10.025 0 0122 12c-1.274 4.057-5.064 7-9.542 7a10.025 10.025 0 01-2.003-.275M3 3l18 18"></path>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="relative">
            <x-input-label for="password" :value="__('Password Baru')" />
            <input id="password" name="password" :type="showNew ? 'text' : 'password'" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-brand-medium focus:border-brand-dark transition duration-150" autocomplete="new-password">
            <div class="absolute inset-y-0 right-0 top-6 pr-3 flex items-center text-sm leading-5">
                <button type="button" @click="showNew = !showNew"
                    class="text-gray-500 relative h-5 w-5 
                       transition duration-200 
                       hover:text-brand-medium hover:scale-110 
                       active:text-brand-dark">

                    <svg x-show="!showNew"
                        x-transition:enter="transition ease-in-out duration-500"
                        x-transition:enter-start="opacity-0 scale-50"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in-out duration-500 absolute top-0"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-50"
                        class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>

                    <svg x-show="showNew" x-cloak
                        x-transition:enter="transition ease-in-out duration-500"
                        x-transition:enter-start="opacity-0 scale-50"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in-out duration-500 absolute top-0"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-50"
                        class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 .844-2.682 2.91-4.942 5.542-6.175M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0A10.025 10.025 0 0122 12c-1.274 4.057-5.064 7-9.542 7a10.025 10.025 0 01-2.003-.275M3 3l18 18"></path>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="relative">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <input id="password_confirmation" name="password_confirmation" :type="showConfirm ? 'text' : 'password'" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-brand-medium focus:border-brand-dark transition duration-150" autocomplete="new-password">
            <div class="absolute inset-y-0 right-0 top-6 pr-3 flex items-center text-sm leading-5">
                <button type="button" @click="showConfirm = !showConfirm"
                    class="text-gray-500 relative h-5 w-5 
                       transition duration-200 
                       hover:text-brand-medium hover:scale-110 
                       active:text-brand-dark">

                    <svg x-show="!showConfirm" class="h-5 w-5"
                        x-transition:enter="transition ease-in-out duration-500"
                        x-transition:enter-start="opacity-0 scale-50"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in-out duration-500 absolute top-0"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>

                    <svg x-show="showConfirm" x-cloak class="h-5 w-5"
                        x-transition:enter="transition ease-in-out duration-500"
                        x-transition:enter-start="opacity-0 scale-50"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in-out duration-500 absolute top-0"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 .844-2.682 2.91-4.942 5.542-6.175M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0A10.025 10.025 0 0122 12c-1.274 4.057-5.064 7-9.542 7a10.025 10.025 0 01-2.003-.275M3 3l18 18"></path>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="bg-brand-dark text-white font-bold py-2 px-4 rounded-lg 
                   transition duration-200 ease-in-out 
                   shadow-lg hover:shadow-xl active:shadow-xl
                   hover:scale-105 hover:opacity-90 active:scale-95">
                {{ __('Simpan') }}
            </button>

            @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>