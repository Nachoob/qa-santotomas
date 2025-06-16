@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-100 ps-3 pe-4 py-2 border-start border-primary text-primary bg-light-primary fw-bold text-decoration-none'
            : 'block w-100 ps-3 pe-4 py-2 border-start border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out text-decoration-none';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
