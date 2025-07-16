<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 leading-tight">
            {{ __('Tambah Pemasukan Baru') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6 text-gray-900">

                    @if (session()->has('message'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('message') }}</p>
                    </div>
                    @endif

                    <form wire:submit.prevent="saveTransaction">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="md:col-span-2">
                                <label for="description" class="block font-medium text-sm text-gray-700">Deskripsi Pemasukan</label>
                                <input id="description" type="text" wire:model="description" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-dark focus:ring-brand-dark">
                                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="amount" class="block font-medium text-sm text-gray-700">Jumlah (Rp)</label>
                                <input id="amount" type="number" step="any" wire:model="amount" placeholder="50000" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-dark focus:ring-brand-dark">
                                @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="transaction_date" class="block font-medium text-sm text-gray-700">Tanggal</label>
                                <input id="transaction_date" type="date" wire:model="transaction_date" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-dark focus:ring-brand-dark">
                                @error('transaction_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="category_id" class="block font-medium text-sm text-gray-700">Kategori</label>
                                <select id="category_id" wire:model="category_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-dark focus:ring-brand-dark">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="payment_method_id" class="block font-medium text-sm text-gray-700">Masuk Ke</label>
                                <select id="payment_method_id" wire:model="payment_method_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-dark focus:ring-brand-dark">
                                    <option value="">Pilih Metode Pembayaran</option>
                                    @foreach ($paymentMethods as $pm)
                                    <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                                    @endforeach
                                </select>
                                @error('payment_method_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="notes" class="block font-medium text-sm text-gray-700">Catatan (Opsional)</label>
                                <textarea id="notes" wire:model="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-dark focus:ring-brand-dark"></textarea>
                                @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-brand-dark hover:bg-brand-darkest text-white font-bold py-2 px-4 rounded-lg transition duration-150">
                                Simpan Pemasukan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>