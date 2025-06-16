@props(['active'])

@php
$classes = ($active ?? false)
            ? 'nav-link active text-white'
            : 'nav-link text-white-50';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
