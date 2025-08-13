<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2 bg-brand-dark text-white p-6 rounded-xl shadow-lg transition-all duration-300 ease-in-out hover:scale-[1.03] hover:shadow-2xl hover:opacity-95 active:scale-[0.97]">
                            <h3 class="text-lg font-semibold text-brand-light">Sisa Uang</h3>
                            <p class="mt-2 text-4xl font-bold">
                                Rp {{ number_format($balance, 0, ',', '.') }}
                            </p>
                            <p class="mt-1 text-sm text-brand-medium">Saldo tersedia</p>
                        </div>
                        <div class="md:col-span-2">
                            <livewire:dashboard-chart :period="$period" :key="'dashboard-chart-'.$period" />
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-6 rounded-xl shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-600">Pemasukan</h3>
                            <p class="mt-2 text-3xl font-bold text-green-600">
                                Rp {{ number_format($totalIncome, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-600">Pengeluaran</h3>
                            <p class="mt-2 text-3xl font-bold text-red-600">
                                Rp {{ number_format($totalExpense, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="col-span-2 h-full">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-md font-semibold text-gray-700 leading-5">Transaksi Terbaru</h4>
                                <div class="flex items-center space-x-2 text-xs">
                                    <a href="{{ route('dashboard', ['period' => 7]) }}" class="{{ $period == 7 ? 'font-bold text-brand-dark' : 'text-gray-400' }} transition-all duration-200 ease-in-out hover:text-brand-darkest hover:-translate-y-0.5 hover:drop-shadow-md active:text-brand-dark active:scale-[0.97] active:font-extrabold">7D</a>
                                    <a href="{{ route('dashboard', ['period' => 30]) }}" class="{{ $period == 30 ? 'font-bold text-brand-dark' : 'text-gray-400' }} transition-all duration-200 ease-in-out hover:text-brand-darkest hover:-translate-y-0.5 hover:drop-shadow-md active:text-brand-dark active:scale-[0.97] active:font-extrabold">30D</a>
                                    <a href="{{ route('dashboard', ['period' => 90]) }}" class="{{ $period == 90 ? 'font-bold text-brand-dark' : 'text-gray-400' }} transition-all duration-200 ease-in-out hover:text-brand-darkest hover:-translate-y-0.5 hover:drop-shadow-md active:text-brand-dark active:scale-[0.97] active:font-extrabold">90D</a>
                                </div>
                            </div>
                            <livewire:dashboard.recent-transactions />
                        </div>
                        <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Anggaran Bulan Ini</h3>
                            @if($totalBudget > 0)
                            <div class="text-sm text-gray-600">
                                <span class="font-bold text-red-600">Rp {{ number_format($monthlyExpense, 0, ',', '.') }}</span> terpakai dari
                                <span class="font-bold text-gray-800">Rp {{ number_format($totalBudget, 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                <div class="bg-red-500 h-2.5 rounded-full" style="width: {{ $progressBarPercentage }}%"></div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1 text-right">{{ number_format($budgetUsagePercentage, 1) }}% terpakai</div>
                            @else
                            <p class="text-sm text-gray-500">
                                Anda belum mengatur anggaran bulan ini.
                                <a href="{{ route('budgets') }}" class="text-indigo-600 hover:underline" wire:navigate>Atur sekarang</a>.
                            </p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>