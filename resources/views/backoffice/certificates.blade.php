@extends('layout')
@section('title', 'Gestión de Certificados')
@section('content')
<div class="container py-4">
    <a href="{{ route('admin.index') }}" class="btn btn-secondary mb-3">← Volver al Panel Admin</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Gestión de Certificados</h4>
        </div>
        <div class="card-body">
            @if($certificates->isEmpty())
                <div class="alert alert-info" role="alert">
                    No hay certificados registrados aún.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Nombre destinatario</th>
                                <th>Tipo</th>
                                <th>Emitido por</th>
                                <th>Fecha emisión</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($certificates as $certificate)
                            @php
                                $isExpired = $certificate->expiry_date && \Carbon\Carbon::parse($certificate->expiry_date)->isPast();
                            @endphp
                                <tr>
                                    <td>{{ $certificate->id }}</td>
                                    <td>{{ $certificate->verification_code }}</td>
                                    <td>{{ $certificate->recipient_name }}</td>
                                    <td>{{ $certificate->certificate_type }}</td>
                                    <td>{{ $certificate->issuer ? $certificate->issuer->name : '-' }}</td>
                                    <td>{{ $certificate->issue_date ? $certificate->issue_date->format('Y-m-d') : '-' }}</td>
                                    <td>
                                        @if($isExpired)
                                            <span class="badge bg-danger">Vencido</span>
                                        @elseif($certificate->status === 'inactive')
                                            <span class="badge bg-secondary">Inactivo</span>
                                        @else
                                            <span class="badge bg-success">Activo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.certificates.destroy', $certificate->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este certificado?')">Eliminar</button>
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