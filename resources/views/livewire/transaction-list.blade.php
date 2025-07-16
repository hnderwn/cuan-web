<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 leading-tight">
            {{ __('Daftar Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6 text-gray-900">

                    @if (session()->has('message'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('message') }}</p>
                    </div>
                    @endif

                    <div class="mb-4">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Cari berdasarkan deskripsi..."
                            class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-brand-dark focus:ring-brand-dark">
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th wire:click="sortBy('transaction_date')" class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider rounded-l-lg">
                                        Tanggal @if($sortField === 'transaction_date') <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                                    </th>
                                    <th wire:click="sortBy('description')" class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Deskripsi @if($sortField === 'description') <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                                    </th>
                                    <th wire:click="sortBy('amount')" class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Jumlah @if($sortField === 'amount') <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Metode Bayar</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider rounded-r-lg">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                <tr wire:key="{{ $transaction->id }}">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $transaction->description }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        @if ($transaction->transaction_type == 'Pemasukan')
                                        <p class="text-green-600 font-semibold whitespace-no-wrap">+ Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                                        @else
                                        <p class="text-red-600 font-semibold whitespace-no-wrap">- Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                                        @endif
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $transaction->category->name ?? 'N/A' }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $transaction->paymentMethod->name ?? 'N/A' }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="{{ route('transactions.edit', $transaction) }}" class="text-green-800 hover:text-green-900">Edit</a>
                                        <button wire:click="deleteTransaction({{ $transaction->id }})" wire:confirm="Yakin mau hapus transaksi ini?" class="text-red-600 hover:text-red-900 ml-4">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-5 text-center text-gray-500">
                                        Tidak ada transaksi yang cocok dengan pencarian "{{ $search }}".
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $transactions->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>