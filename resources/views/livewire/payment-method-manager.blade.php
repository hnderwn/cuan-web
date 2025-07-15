<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Metode Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form wire:submit.prevent="{{ $editingPaymentMethodId ? 'updatePaymentMethod' : 'savePaymentMethod' }}" class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">{{ $editingPaymentMethodId ? 'Edit Metode Pembayaran' : 'Tambah Metode Pembayaran Baru' }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Nama Metode</label>
                                <input id="name" type="text" wire:model="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-end space-x-2">
                                <button type="submit" class="{{ $editingPaymentMethodId ? 'bg-blue-600 hover:bg-blue-800' : 'bg-indigo-600 hover:bg-indigo-800' }} text-white font-bold py-2 px-4 rounded">
                                    {{ $editingPaymentMethodId ? 'Update Metode' : 'Simpan Metode' }}
                                </button>
                                @if ($editingPaymentMethodId)
                                <button type="button" wire:click="cancelEdit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Batal
                                </button>
                                @endif
                            </div>
                        </div>
                    </form>

                    @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                    @endif

                    <div class="mt-6">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($paymentMethods as $pm)
                                <tr wire:key="{{ $pm->id }}">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $pm->name }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                        <button wire:click="editPaymentMethod({{ $pm->id }})" class="text-blue-600 hover:text-blue-900">Edit</button>
                                        <button wire:click="deletePaymentMethod({{ $pm->id }})" wire:confirm="Yakin mau hapus metode '{{ $pm->name }}'?" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="px-5 py-5 text-center text-gray-500">
                                        Belum ada metode pembayaran.
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