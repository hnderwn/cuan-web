<div class="flex flex-col h-full bg-brand-darkest">
  <div class="flex items-center justify-center h-20 shrink-0">
    <a href="{{ route('dashboard') }}" class="text-white text-2xl font-bold overflow-hidden" :class="sidebarFull ? 'w-auto' : 'w-0'" wire:navigate>Cuan-Web</a>
    <a href="{{ route('dashboard') }}" class="text-white text-2xl font-bold overflow-hidden" :class="!sidebarFull ? 'w-auto' : 'w-0'" wire:navigate>C</a>
  </div>
  <nav class="flex-1 px-2 py-4 space-y-6">
    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
      <x-slot name="icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg></x-slot>
      {{ __('Dashboard') }}
    </x-sidebar-link>
    <x-sidebar-link :href="route('transactions.index')" :active="request()->routeIs('transactions.index')" wire:navigate>
      <x-slot name="icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
        </svg></x-slot>
      {{ __('Daftar Transaksi') }}
    </x-sidebar-link>
    <x-sidebar-link :href="route('incomes.create')" :active="request()->routeIs('incomes.create')" wire:navigate>
      <x-slot name="icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg></x-slot>
      {{ __('Tambah Pemasukan') }}
    </x-sidebar-link>
    <x-sidebar-link :href="route('expenses.create')" :active="request()->routeIs('expenses.create')" wire:navigate>
      <x-slot name="icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg></x-slot>
      {{ __('Tambah Pengeluaran') }}
    </x-sidebar-link>
    <x-sidebar-link :href="route('categories')" :active="request()->routeIs('categories')" wire:navigate>
      <x-slot name="icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg></x-slot>
      {{ __('Kategori') }}
    </x-sidebar-link>
    <x-sidebar-link :href="route('payment-methods')" :active="request()->routeIs('payment-methods')" wire:navigate>
      <x-slot name="icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
        </svg></x-slot>
      {{ __('Metode Bayar') }}
    </x-sidebar-link>
    <x-sidebar-link :href="route('import')" :active="request()->routeIs('import')" wire:navigate>
      <x-slot name="icon">{{-- Ganti dengan ikon upload --}}
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
        </svg>
      </x-slot>
      {{ __('Import CSV') }}
    </x-sidebar-link>
  </nav>
</div>