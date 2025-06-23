@extends('layout')
@section('title', 'Panel de Administración')
@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h2>Panel de Administración</h2>
            <p class="lead">Bienvenido, {{ auth()->user()->name }}.</p>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Usuarios registrados</h5>
                    <p class="display-6">{{ $usersCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Certificados emitidos</h5>
                    <p class="display-6">{{ $certificatesCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Administradores</h5>
                    <p class="display-6">{{ $adminsCount }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <a href="{{ route('admin.users') }}" class="btn btn-primary me-2">Gestionar usuarios</a>
            <a href="{{ route('admin.certificates') }}" class="btn btn-secondary">Gestionar certificados</a>
        </div>
    </div>
</div>
@endsection