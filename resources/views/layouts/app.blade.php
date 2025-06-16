@extends('layout')

@section('content')
<div class="min-h-screen bg-light">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white shadow-sm mt-3 py-4 px-4">
            <div class="container">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Page Content -->
    <main class="container py-4">
        {{ $slot }}
    </main>
</div>
@endsection
