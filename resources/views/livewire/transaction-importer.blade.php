<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 leading-tight">
            {{ __('Impor Transaksi dari CSV') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6 text-gray-900">

                    @if (session()->has('message'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('message') }}</p>
                    </div>
                    @endif

                    @if (session()->has('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                    @endif

                    <div class="mb-6 p-4 border rounded-lg bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Panduan Format CSV</h3>
                        <p class="text-sm text-gray-600 mb-4">Pastikan file CSV Anda memiliki header dan format seperti contoh di bawah ini. Kolom `tipe` harus diisi dengan "Pemasukan" atau "Pengeluaran".</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="p-2">tanggal</th>
                                        <th class="p-2">deskripsi</th>
                                        <th class="p-2">jumlah</th>
                                        <th class="p-2">tipe</th>
                                        <th class="p-2">kategori</th>
                                        <th class="p-2">metode_bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="p-2">2025-07-17</td>
                                        <td class="p-2">Kopi Kenangan</td>
                                        <td class="p-2">22000</td>
                                        <td class="p-2">Pengeluaran</td>
                                        <td class="p-2">Makanan</td>
                                        <td class="p-2">GoPay</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('import.template') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Download Template
                            </a>
                        </div>
                    </div>

                    <form wire:submit.prevent="import">
                        <div>
                            <label for="csvFile" class="block font-medium text-sm text-gray-700">Pilih File CSV</label>
                            <input type="file" id="csvFile" wire:model="csvFile" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-lightest file:text-brand-dark hover:file:bg-brand-light">
                            <div wire:loading wire:target="csvFile" class="text-sm text-gray-500 mt-1">Uploading...</div>
                            @error('csvFile') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="bg-brand-dark hover:bg-brand-darkest text-white font-bold py-2 px-4 rounded-lg transition duration-150">
                                <span wire:loading.remove wire:target="import">Impor Sekarang</span>
                                <span wire:loading wire:target="import">Mengimpor...</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>