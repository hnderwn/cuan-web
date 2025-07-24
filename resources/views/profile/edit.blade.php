<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 leading-tight">
            {{ __('Profil Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6">
                    {{-- Bagian Form Informasi Profil --}}
                    <div class="max-w-3xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    {{-- Garis Pemisah --}}
                    <div class="border-t border-gray-200 my-6"></div>

                    {{-- Bagian Form Update Password --}}
                    <div class="max-w-3xl">
                        @include('profile.partials.update-password-form')
                    </div>

                    {{-- Garis Pemisah --}}
                    <div class="border-t border-gray-200 my-6"></div>

                    {{-- Bagian Form Hapus Akun --}}
                    <div class="max-w-3xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                    
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-xl">
                        <div class="max-w-xl">
                            @livewire('profile.telegram-integration')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>