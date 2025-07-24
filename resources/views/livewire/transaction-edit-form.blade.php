<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl"> {{-- Ganti sm:rounded-lg jadi rounded-xl biar konsisten --}}
                <div class="p-6 text-gray-900">

                    <form wire:submit.prevent="updateTransaction">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="transaction_type" class="block font-medium text-sm text-gray-700">Tipe Transaksi</label>
                                <select id="transaction_type" wire:model.live="transaction_type"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm {{-- Ganti rounded-md jadi rounded-lg --}}
                                           focus:border-brand-dark focus:ring-brand-dark
                                           transition duration-300 focus:shadow-md focus:scale-[1.005]">
                                    <option value="Pengeluaran">Pengeluaran</option>
                                    <option value="Pemasukan">Pemasukan</option>
                                </select>
                            </div>
                            <div>
                                <label for="category_id" class="block font-medium text-sm text-gray-700">Kategori</label>
                                <select id="category_id" wire:model="category_id"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm {{-- Ganti rounded-md jadi rounded-lg --}}
                                           focus:border-brand-dark focus:ring-brand-dark
                                           transition duration-300 focus:shadow-md focus:scale-[1.005]">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="amount" class="block font-medium text-sm text-gray-700">Jumlah (Rp)</label>
                                <input id="amount" type="number" step="any" wire:model="amount"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm {{-- Ganti rounded-md jadi rounded-lg --}}
                                          focus:border-brand-dark focus:ring-brand-dark
                                          transition duration-300 focus:shadow-md focus:scale-[1.005]">
                                @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="transaction_date" class="block font-medium text-sm text-gray-700">Tanggal Transaksi</label>
                                <input id="transaction_date" type="date" wire:model="transaction_date"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm {{-- Ganti rounded-md jadi rounded-lg --}}
                                          focus:border-brand-dark focus:ring-brand-dark
                                          transition duration-300 focus:shadow-md focus:scale-[1.005]">
                                @error('transaction_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="description" class="block font-medium text-sm text-gray-700">Deskripsi</label>
                                <input id="description" type="text" wire:model="description"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm {{-- Ganti rounded-md jadi rounded-lg --}}
                                          focus:border-brand-dark focus:ring-brand-dark
                                          transition duration-300 focus:shadow-md focus:scale-[1.005]">
                                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="payment_method_id" class="block font-medium text-sm text-gray-700">Metode Pembayaran</label>
                                <select id="payment_method_id" wire:model="payment_method_id"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm {{-- Ganti rounded-md jadi rounded-lg --}}
                                           focus:border-brand-dark focus:ring-brand-dark
                                           transition duration-300 focus:shadow-md focus:scale-[1.005]">
                                    <option value="">Pilih Metode Pembayaran</option>
                                    @foreach ($paymentMethods as $pm)
                                    <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                                    @endforeach
                                </select>
                                @error('payment_method_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="notes" class="block font-medium text-sm text-gray-700">Catatan (Opsional)</label>
                                <textarea id="notes" wire:model="notes" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm {{-- Ganti rounded-md jadi rounded-lg --}}
                                             focus:border-brand-dark focus:ring-brand-dark
                                             transition duration-300 focus:shadow-md focus:scale-[1.005]"></textarea>
                                @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="bg-brand-dark hover:opacity-90 text-white font-bold py-2 px-4 rounded-lg {{-- Ganti rounded jadi rounded-lg --}}
                                       transition duration-200 ease-in-out
                                       shadow-lg hover:shadow-xl active:shadow-md
                                       hover:scale-105 active:scale-95">
                                Update Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>