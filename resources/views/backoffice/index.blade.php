@extends('layout')
@section('title', 'Panel de Administración')
@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">{{ __('Panel de Administración - Certificados') }}</h4>
        </div>
        <div class="card-body">
            @if($certificates->isEmpty())
                <div class="alert alert-info" role="alert">
                    {{ __('No hay certificados registrados aún.') }}
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Código') }}</th>
                                <th>{{ __('Nombre') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Actividad') }}</th>
                                <th>{{ __('Acciones') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($certificates as $certificate)
                                <tr>
                                    <td>{{ $certificate->id }}</td>
                                    <td>{{ $certificate->code }}</td>
                                    <td>{{ $certificate->name }}</td>
                                    <td>{{ $certificate->email }}</td>
                                    <td>{{ $certificate->last_activity }}</td>
                                    <td>
                                        <a href="{{ route('certificates.show', $certificate->id) }}" class="btn btn-info btn-sm">{{ __('Ver') }}</a>
                                        <a href="{{ route('certificates.edit', $certificate->id) }}" class="btn btn-warning btn-sm">{{ __('Editar') }}</a>
                                        <form action="{{ route('certificates.destroy', $certificate->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('¿Estás seguro de que quieres eliminar este certificado?') }}')">{{ __('Eliminar') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $certificates->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection