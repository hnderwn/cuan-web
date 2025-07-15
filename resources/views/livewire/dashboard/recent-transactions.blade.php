<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Transaksi Terbaru</h3>
        <div class="space-y-4">
            @forelse ($transactions as $transaction)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full {{ $transaction->transaction_type == 'Pemasukan' ? 'bg-green-100' : 'bg-red-100' }}">
                            {{-- Icon (bisa diganti dengan SVG) --}}
                            <span class="text-xl">{{ $transaction->transaction_type == 'Pemasukan' ? '💰' : '💸' }}</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-gray-800">{{ $transaction->description }}</p>
                            <p class="text-xs text-gray-500">{{ $transaction->category->name ?? 'N/A' }} &middot; {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M') }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-semibold {{ $transaction->transaction_type == 'Pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->transaction_type == 'Pemasukan' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada transaksi.</p>
            @endforelse
        </div>
    </div>
</div>