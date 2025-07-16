@props(['active'])

@php
$classes = ($active ?? false)
? 'flex items-center p-2 text-base font-medium text-white bg-brand-dark rounded-lg group'
: 'flex items-center p-2 text-base font-medium text-brand-light rounded-lg hover:text-white hover:bg-brand-dark group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
  <span class="shrink-0">
    {{ $icon }}
  </span>
  {{-- Alpine akan otomatis menemukan `sidebarFull` dari parent --}}
  <span class="ml-3 flex-1 whitespace-nowrap overflow-hidden transition-all duration-300" :class="sidebarFull ? 'w-auto' : 'w-0'">
    {{ $slot }}
  </span>
</a>