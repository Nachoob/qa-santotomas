@extends('layout')
@section('title', 'Listado de Certificados')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card card-minimal p-4">
            <h3 class="mb-4">Listado de Certificados</h3>
            <a href="{{ route('certificates.create') }}" class="btn btn-success mb-3">Nuevo certificado</a>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Fecha emisión</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($certificates as $certificate)
                        <tr>
                            <td>{{ $certificate->recipient_name }}</td>
                            <td>{{ $certificate->recipient_email }}</td>
                            <td>{{ $certificate->certificate_type }}</td>
                            <td>{{ $certificate->issue_date }}</td>
                            <td>{{ $certificate->status }}</td>
                            <td>
                                <a href="{{ route('certificates.show', $certificate) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $certificates->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection 