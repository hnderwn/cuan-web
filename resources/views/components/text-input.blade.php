@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-brand-dark focus:ring-brand-medium rounded-lg shadow-sm transition duration-150' ]) }}>