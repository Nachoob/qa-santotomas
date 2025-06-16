@props(['name', 'show' => false, 'maxWidth' => '2xl', 'closeable' => true])

@php
    $maxWidth = [
        'sm' => 'modal-sm',
        'md' => 'modal-md',
        'lg' => 'modal-lg',
        'xl' => 'modal-xl',
        '2xl' => 'modal-dialog-centered',
    ][$maxWidth] ?? $maxWidth;
@endphp

<div
    x-data="{ show: @js($show) }"
    x-show="show"
    x-on:open-modal.window="$event.detail.name === '$name' ? show = true : null"
    x-on:close-modal.window="$event.detail.name === '$name' ? show = false : null"
    x-on:keydown.escape.window="{{ $closeable ? 'show = false' : '' }}"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
    style="display: {{ $show ? 'block' : 'none' }};"
    x-init="
        $watch('show', value => {
            if (value) {
                document.body.classList.add('modal-open');
                document.querySelector('#{{ $name }}').classList.add('show');
                document.querySelector('#{{ $name }}').style.display = 'block';
            } else {
                document.body.classList.remove('modal-open');
                document.querySelector('#{{ $name }}').classList.remove('show');
                document.querySelector('#{{ $name }}').style.display = 'none';
            }
        });
    "
    id="{{ $name }}"
>
    <div class="modal-dialog {{ $maxWidth }}" role="document">
        <div class="modal-content">
            {{ $slot }}
        </div>
    </div>
</div>
