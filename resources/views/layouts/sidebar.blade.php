<div class="flex flex-col h-full bg-brand-darkest">
  <div class="flex items-center justify-center h-20 shrink-0">
    <a href="{{ route('dashboard') }}" class="text-white font-bold overflow-hidden flex items-center justify-center h-full transition-all duration-300 ease-in-out group" :class="sidebarFull ? 'w-auto text-2xl' : 'w-10 text-xl'" wire:navigate>
      <svg class="h-10 w-10 text-white flex-shrink-0 transition-transform duration-200 ease-in-out group-hover:-translate-y-0.5 group-hover:rotate-6 group-active:scale-90" viewBox="-6.4 -6.4 44.80 44.80" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M31,7H1A1,1,0,0,0,0,8V24a1,1,0,0,0,1,1H31a1,1,0,0,0,1-1V8A1,1,0,0,0,31,7ZM25.09,23H6.91A6,6,0,0,0,2,18.09V13.91A6,6,0,0,0,6.91,9H25.09A6,6,0,0,0,30,13.91v4.18A6,6,0,0,0,25.09,23ZM30,11.86A4,4,0,0,1,27.14,9H30ZM4.86,9A4,4,0,0,1,2,11.86V9ZM2,20.14A4,4,0,0,1,4.86,23H2ZM27.14,23A4,4,0,0,1,30,20.14V23Z"></path>
        <path d="M7.51.71a1,1,0,0,0-.76-.1,1,1,0,0,0-.61.46l-2,3.43a1,1,0,0,0,1.74,1L7.38,2.94l5.07,2.93a1,1,0,0,0,1-1.74Z"></path>
        <path d="M24.49,31.29a1,1,0,0,0,.5.14.78.78,0,0,0,.26,0,1,1,0,0,0,.61-.46l2-3.43a1,1,0,1,0-1.74-1l-1.48,2.56-5.07-2.93a1,1,0,0,0-1,1.74Z"></path>
        <path d="M16,10a6,6,0,1,0,6,6A6,6,0,0,0,16,10Zm0,10a4,4,0,1,1,4-4A4,4,0,0,1,16,20Z"></path>
      </svg>
      <span :class="sidebarFull ? 'ml-2' : 'hidden'">Cuan-Web</span>
    </a>
  </div>

  <nav class="flex-1 px-2 py-4 space-y-6">
    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate
      class="transition-all duration-300 ease-in-out
                   hover:bg-brand-dark hover:text-white hover:rounded-lg hover:shadow-md hover:scale-[1.02] transform
                   active:bg-brand-light active:text-brand-darkest active:shadow-inner active:scale-[0.98]">
      <x-slot name="icon"><svg class="w-6 h-6 transition-transform duration-300 ease-in-out hover:-translate-y-0.5 hover:rotate-6 active:scale-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"> {{-- Tambah efek di sini --}}
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg></x-slot>
      {{ __('Dashboard') }}
    </x-sidebar-link>
    <x-sidebar-link :href="route('transactions.index')" :active="request()->routeIs('transactions.index')" wire:navigate
      class="transition-all duration-300 ease-in-out
                   hover:bg-brand-dark hover:text-white hover:rounded-lg hover:shadow-md hover:scale-[1.02] transform
                   active:bg-brand-light active:text-brand-darkest active:shadow-inner active:scale-[0.98]">
      <x-slot name="icon"><svg class="w-6 h-6 transition-transform duration-300 ease-in-out hover:-translate-y-0.5 hover:rotate-6 active:scale-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
        </svg></x-slot>
      {{ __('Daftar Transaksi') }}
    </x-sidebar-link>
    <x-sidebar-link :href="route('incomes.create')" :active="request()->routeIs('incomes.create')" wire:navigate
      class="transition-all duration-300 ease-in-out
                   hover:bg-brand-dark hover:text-white hover:rounded-lg hover:shadow-md hover:scale-[1.02] transform
                   active:bg-brand-light active:text-brand-darkest active:shadow-inner active:scale-[0.98]">
      <x-slot name="icon"><svg class="w-6 h-6 transition-transform duration-300 ease-in-out hover:-translate-y-0.5 hover:rotate-6 active:scale-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg></x-slot>
      {{ __('Tambah Pemasukan') }}
    </x-sidebar-link>
    <x-sidebar-link :href="route('expenses.create')" :active="request()->routeIs('expenses.create')" wire:navigate
      class="transition-all duration-300 ease-in-out
                   hover:bg-brand-dark hover:text-white hover:rounded-lg hover:shadow-md hover:scale-[1.02] transform
                   active:bg-brand-light active:text-brand-darkest active:shadow-inner active:scale-[0.98]">
      <x-slot name="icon"><svg class="w-6 h-6 transition-transform duration-300 ease-in-out hover:-translate-y-0.5 hover:rotate-6 active:scale-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg></x-slot>
      {{ __('Tambah Pengeluaran') }}
    </x-sidebar-link>
    <x-sidebar-link :href="route('categories')" :active="request()->routeIs('categories')" wire:navigate
      class="transition-all duration-300 ease-in-out
                   hover:bg-brand-dark hover:text-white hover:rounded-lg hover:shadow-md hover:scale-[1.02] transform
                   active:bg-brand-light active:text-brand-darkest active:shadow-inner active:scale-[0.98]">
      <x-slot name="icon"><svg class="w-6 h-6 transition-transform duration-300 ease-in-out hover:-translate-y-0.5 hover:rotate-6 active:scale-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg></x-slot>
      {{ __('Kategori') }}
    </x-sidebar-link>
    <x-sidebar-link :href="route('payment-methods')" :active="request()->routeIs('payment-methods')" wire:navigate
      class="transition-all duration-300 ease-in-out
                   hover:bg-brand-dark hover:text-white hover:rounded-lg hover:shadow-md hover:scale-[1.02] transform
                   active:bg-brand-light active:text-brand-darkest active:shadow-inner active:scale-[0.98]">
      <x-slot name="icon"><svg class="w-6 h-6 transition-transform duration-300 ease-in-out hover:-translate-y-0.5 hover:rotate-6 active:scale-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
        </svg></x-slot>
      {{ __('Metode Bayar') }}
    </x-sidebar-link>
    <x-sidebar-link :href="route('budgets')" :active="request()->routeIs('budgets')" wire:navigate>
      <x-slot name="icon">
        {{-- Ikon Target/Budget --}}
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
      </x-slot>
      {{ __('Anggaran') }}
    </x-sidebar-link>
    <x-sidebar-link :href="route('import')" :active="request()->routeIs('import')" wire:navigate
      class="transition-all duration-300 ease-in-out
                   hover:bg-brand-dark hover:text-white hover:rounded-lg hover:shadow-md hover:scale-[1.02] transform
                   active:bg-brand-light active:text-brand-darkest active:shadow-inner active:scale-[0.98]">
      <x-slot name="icon">{{-- Ganti dengan ikon upload --}}
        <svg class="w-6 h-6 transition-transform duration-300 ease-in-out hover:-translate-y-0.5 hover:rotate-6 active:scale-90" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/3000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
        </svg>
      </x-slot>
      {{ __('Import CSV') }}
    </x-sidebar-link>
  </nav>
</div>