<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex items-center justify-end space-x-4 text-sm">
                <span class="font-semibold">Periode:</span>
                <a href="{{ route('dashboard', ['period' => 7]) }}" class="{{ $period == 7 ? 'font-bold text-indigo-600' : 'text-gray-500' }} hover:text-indigo-600">7 Hari</a>
                <a href="{{ route('dashboard', ['period' => 30]) }}" class="{{ $period == 30 ? 'font-bold text-indigo-600' : 'text-gray-500' }} hover:text-indigo-600">30 Hari</a>
                <a href="{{ route('dashboard', ['period' => 90]) }}" class="{{ $period == 90 ? 'font-bold text-indigo-600' : 'text-gray-500' }} hover:text-indigo-600">90 Hari</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-600">Total Pemasukan</h3>
                        <p class="mt-2 text-3xl font-bold text-green-600">
                            Rp {{ number_format($totalIncome, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-600">Total Pengeluaran</h3>
                        <p class="mt-2 text-3xl font-bold text-red-600">
                            Rp {{ number_format($totalExpense, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-600">Sisa Uang</h3>
                        <p class="mt-2 text-3xl font-bold {{ $balance >= 0 ? 'text-blue-600' : 'text-yellow-600' }}">
                            Rp {{ number_format($balance, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>