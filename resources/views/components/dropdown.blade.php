@props(['align' => 'end', 'width' => '48', 'contentClasses' => 'py-1 bg-white'])

@php
    $width = [
        '48' => 'w-48',
    ][$width] ?? $width;

    $alignmentClasses = match ($align) {
        'start' => 'dropdown-menu',
        'end' => 'dropdown-menu dropdown-menu-end',
        default => 'dropdown-menu',
    };
@endphp

<div class="dropdown" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open" class="dropdown-toggle" role="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $trigger }}
    </div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="{{ $alignmentClasses }} position-absolute mt-2 {{ $width }} {{ $contentClasses }}"
         style="display: none;"
         @click="open = false">
        {{ $content }}
    </div>
</div>
