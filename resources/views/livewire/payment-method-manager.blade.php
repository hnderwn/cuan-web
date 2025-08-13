<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 leading-tight">
            {{ __('Metode Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6 text-gray-900">

                    <form wire:submit.prevent="{{ $editingPaymentMethodId ? 'updatePaymentMethod' : 'savePaymentMethod' }}" class="mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">{{ $editingPaymentMethodId ? 'Edit Metode Pembayaran' : 'Tambah Metode Baru' }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <label for="name" class="block font-medium text-sm text-gray-700">Nama Metode</label>
                                <input id="name" type="text" wire:model="name"
                                    class="mt-1 block w-full border-gray-300 rounded-lg
                                          shadow-sm focus:border-brand-dark focus:ring-brand-dark
                                          transition duration-300 focus:shadow-md focus:scale-[1.005]">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-end space-x-2">
                                <button type="submit"
                                    class="{{ $editingPaymentMethodId ? 'bg-blue-600 hover:bg-blue-700' : 'bg-brand-dark hover:bg-brand-darkest' }}
                                           text-white font-bold py-2 px-4 rounded-lg
                                           transition duration-200 ease-in-out
                                           shadow-lg hover:shadow-xl active:shadow-md
                                           hover:scale-105 active:scale-95">
                                    {{ $editingPaymentMethodId ? 'Update Metode' : 'Simpan' }}
                                </button>
                                @if ($editingPaymentMethodId)
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
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 rounded-r-lg"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($paymentMethods as $pm)
                                <tr wire:key="{{ $pm->id }}"
                                    class="transition duration-150 ease-in-out hover:bg-gray-50 hover:shadow-md">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $pm->name }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                        <button wire:click="editPaymentMethod({{ $pm->id }})"
                                            class="text-green-800 hover:text-green-600
                                                   transition duration-200 ease-in-out
                                                   hover:scale-105 active:scale-95
                                                   hover:-translate-y-0.5 transform focus:outline-none">
                                            Edit
                                        </button>
                                        <button wire:click="deletePaymentMethod({{ $pm->id }})" wire:confirm="Yakin mau hapus metode '{{ $pm->name }}'?"
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