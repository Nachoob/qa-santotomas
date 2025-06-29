@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-start border-primary text-start text-base font-weight-bold text-primary bg-light focus:outline-none focus:text-primary focus:bg-light focus:border-primary transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-start border-transparent text-start text-base font-weight-medium text-secondary hover:text-dark hover:bg-light hover:border-gray-300 focus:outline-none focus:text-dark focus:bg-light focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
