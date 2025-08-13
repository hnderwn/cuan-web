<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 leading-tight">
            {{ __('Kategori') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6 text-gray-900">

                    <form wire:submit.prevent="{{ $editingCategoryId ? 'updateCategory' : 'saveCategory' }}" class="mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">{{ $editingCategoryId ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Nama Kategori</label>
                                <input id="name" type="text" wire:model="name"
                                    class="mt-1 block w-full border-gray-300 rounded-lg
                                          shadow-sm focus:border-brand-dark focus:ring-brand-dark
                                          transition duration-300 focus:shadow-md focus:scale-[1.005]">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="transaction_type" class="block font-medium text-sm text-gray-700">Tipe Transaksi</label>
                                <select id="transaction_type" wire:model="transaction_type"
                                    class="mt-1 block w-full border-gray-300 rounded-lg
                                           shadow-sm focus:border-brand-dark focus:ring-brand-dark
                                           transition duration-300 focus:shadow-md focus:scale-[1.005]">
                                    <option value="Pengeluaran">Pengeluaran</option>
                                    <option value="Pemasukan">Pemasukan</option>
                                </select>
                                @error('transaction_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-end space-x-2">
                                <button type="submit"
                                    class="{{ $editingCategoryId ? 'bg-blue-600 hover:bg-blue-700' : 'bg-brand-dark hover:bg-brand-darkest' }}
                                           text-white font-bold py-2 px-4 rounded-lg
                                           transition duration-200 ease-in-out
                                           shadow-lg hover:shadow-xl active:shadow-md
                                           hover:scale-105 active:scale-95">
                                    {{ $editingCategoryId ? 'Update Kategori' : 'Simpan' }}
                                </button>
                                @if ($editingCategoryId)
                                <button type="button" wire:click="cancelEdit"
                                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg
                                           transition duration-200 ease-in-out
                                           shadow-lg hover:shadow-xl active:shadow-md
                                           hover:scale-105 active:scale-95">
                                    Batal
                                </button>
                                @endif
                            </div>
                        </div>
                    </form>

                    @if (session()->has('message'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('message') }}</p>
                    </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider rounded-l-lg">Nama</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipe Transaksi</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 rounded-r-lg"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                <tr wire:key="{{ $category->id }}"
                                    class="transition duration-150 ease-in-out hover:bg-gray-50 hover:shadow-md">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $category->name }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $category->transaction_type }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                        <button wire:click="editCategory({{ $category->id }})"
                                            class="text-green-800 hover:text-green-600
                                                   transition duration-200 ease-in-out
                                                   hover:scale-105 active:scale-95
                                                   hover:-translate-y-0.5 transform focus:outline-none">
                                            Edit
                                        </button>
                                        <button wire:click="deleteCategory({{ $category->id }})" wire:confirm="Yakin mau hapus kategori '{{ $category->name }}'?"
                                            class="text-red-600 hover:text-red-400 ml-4
                                                   transition duration-200 ease-in-out
                                                   hover:scale-105 active:scale-95
                                                   hover:-translate-y-0.5 transform focus:outline-none">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-5 py-5 text-center text-gray-500">
                                        Belum ada kategori.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>