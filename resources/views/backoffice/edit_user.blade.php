@extends('layout')
@section('title', 'Editar Usuario')
@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Editar Usuario</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="is_admin" class="form-label">¿Es administrador?</label>
                    <select class="form-select" id="is_admin" name="is_admin">
                        <option value="1" {{ old('is_admin', $user->is_admin) ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ !old('is_admin', $user->is_admin) ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Guardar cambios</button>
                <a href="{{ route('admin.users') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection 