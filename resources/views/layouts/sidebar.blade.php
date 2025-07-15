<div class="flex flex-col h-full bg-brand-darkest">
  <div class="flex items-center justify-center h-20">
    {{-- Logo atau nama aplikasi --}}
    <a href="{{ route('dashboard') }}" class="text-white text-2xl font-bold">Cuan-Web</a>
  </div>

  <nav class="flex-1 px-2 py-4 space-y-2">
    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
      {{ __('Dashboard') }}
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.index')">
      {{ __('Daftar Transaksi') }}
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('incomes.create')" :active="request()->routeIs('incomes.create')">
      {{ __('Tambah Pemasukan') }}
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('expenses.create')" :active="request()->routeIs('expenses.create')">
      {{ __('Tambah Pengeluaran') }}
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('categories')" :active="request()->routeIs('categories')">
      {{ __('Kategori') }}
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('payment-methods')" :active="request()->routeIs('payment-methods')">
      {{ __('Metode Bayar') }}
    </x-responsive-nav-link>
  </nav>
</div>