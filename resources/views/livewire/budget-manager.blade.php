<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 leading-tight">
            {{ __('Atur Anggaran Bulanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6 text-gray-900">

                    @if (session()->has('message'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('message') }}</p>
                    </div>
                    @endif

                    <form wire:submit.prevent="saveBudgets">
                        <div class="mb-4">
                            <label for="period" class="block font-medium text-sm text-gray-700">Pilih Bulan & Tahun</label>
                            <input type="month" id="period" wire:model.live="period" class="mt-1 block border-gray-300 rounded-lg shadow-sm">
                        </div>

                        <div class="space-y-4">
                            @forelse ($budgets as $index => $budget)
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="budget-{{ $budget['category_id'] }}" class="col-span-1 text-sm font-medium text-gray-800">{{ $budget['category_name'] }}</label>
                                <div class="col-span-2">
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</span>
                                        <input
                                            id="budget-{{ $budget['category_id'] }}"
                                            type="number"
                                            wire:model="budgets.{{ $index }}.amount"
                                            class="pl-10 block w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-dark focus:ring-brand-medium transition duration-150"
                                            placeholder="0">
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500">
                                Kamu belum punya kategori pengeluaran. Silakan buat di halaman "Kategori" terlebih dahulu.
                            </p>
                            @endforelse
                        </div>

                        @if (!empty($budgets))
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-brand-dark hover:bg-brand-darkest text-white font-bold py-2 px-4 rounded-lg transition-transform duration-150 hover:scale-105 active:scale-95">
                                Simpan Anggaran
                            </button>
                        </div>
                        @endif
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>