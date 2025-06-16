@extends('layout')
@section('title', 'Detalle de Certificado')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-minimal p-4">
            <h3 class="mb-4">Detalle de Certificado</h3>
            <dl class="row">
                <dt class="col-sm-4">Nombre</dt>
                <dd class="col-sm-8">{{ $certificate->recipient_name }}</dd>
                <dt class="col-sm-4">Email</dt>
                <dd class="col-sm-8">{{ $certificate->recipient_email }}</dd>
                <dt class="col-sm-4">Tipo</dt>
                <dd class="col-sm-8">{{ $certificate->certificate_type }}</dd>
                <dt class="col-sm-4">Fecha emisión</dt>
                <dd class="col-sm-8">{{ $certificate->issue_date }}</dd>
                <dt class="col-sm-4">Fecha expiración</dt>
                <dd class="col-sm-8">{{ $certificate->expiry_date ?? 'No expira' }}</dd>
                <dt class="col-sm-4">Código verificación</dt>
                <dd class="col-sm-8">{{ $certificate->verification_code }}</dd>
                <dt class="col-sm-4">Estado</dt>
                <dd class="col-sm-8">{{ $certificate->status }}</dd>
            </dl>
            @if($certificate->file_path ?? false)
                <a href="{{ asset('storage/' . $certificate->file_path) }}" class="btn btn-outline-primary" download>Descargar archivo</a>
            @endif
        </div>
    </div>
</div>
@endsection 