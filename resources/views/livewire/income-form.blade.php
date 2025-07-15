<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pemasukan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                    @endif

                    <form wire:submit.prevent="saveTransaction">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="category_id" class="block font-medium text-sm text-gray-700">Kategori</label>
                                <select id="category_id" wire:model="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="amount" class="block font-medium text-sm text-gray-700">Jumlah (Rp)</label>
                                <input id="amount" type="number" step="any" wire:model="amount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="transaction_date" class="block font-medium text-sm text-gray-700">Tanggal Transaksi</label>
                                <input id="transaction_date" type="date" wire:model="transaction_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @error('transaction_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="description" class="block font-medium text-sm text-gray-700">Deskripsi</label>
                                <input id="description" type="text" wire:model="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="payment_method_id" class="block font-medium text-sm text-gray-700">Sumber Pendapatan</label>
                                <select id="payment_method_id" wire:model="payment_method_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Pilih Sumber Pendapatan</option>
                                    @foreach ($paymentMethods as $pm)
                                    <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                                    @endforeach
                                </select>
                                @error('payment_method_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="notes" class="block font-medium text-sm text-gray-700">Catatan (Opsional)</label>
                                <textarea id="notes" wire:model="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                                @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">
                                Simpan Transaksi
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>