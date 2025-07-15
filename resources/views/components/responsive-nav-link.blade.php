@props(['active'])

@php
$classes = ($active ?? false)
? 'block w-full ps-3 pe-4 py-2 text-start text-base font-medium text-white bg-brand-dark focus:outline-none transition duration-150 ease-in-out'
: 'block w-full ps-3 pe-4 py-2 text-start text-base font-medium text-brand-light hover:text-white hover:bg-brand-dark focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>