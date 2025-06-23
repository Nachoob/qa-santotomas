@extends('layout')
@section('title', 'Detalle de Certificado')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-minimal p-4">
            <h3 class="mb-4">Detalle de Certificado</h3>
            <p class="text-muted mb-4">Aquí puedes consultar toda la información relevante sobre el certificado seleccionado, incluyendo sus datos, estado y código de verificación.</p>
            <dl class="row">
                <dt class="col-sm-4">Nombre</dt>
                <dd class="col-sm-8">{{ $certificate->recipient_name }}</dd>
                <dt class="col-sm-4">Email</dt>
                <dd class="col-sm-8">{{ $certificate->recipient_email }}</dd>
                <dt class="col-sm-4">Tipo</dt>
                <dd class="col-sm-8">
                    @php
                        $typeTranslations = [
                            'course' => 'Curso',
                            'achievement' => 'Logro',
                            'participation' => 'Participación',
                        ];
                    @endphp
                    {{ $typeTranslations[$certificate->certificate_type] ?? $certificate->certificate_type }}
                </dd>
                <dt class="col-sm-4">Fecha emisión</dt>
                <dd class="col-sm-8">{{ $certificate->issue_date }}</dd>
                <dt class="col-sm-4">Fecha expiración</dt>
                <dd class="col-sm-8">{{ $certificate->expiry_date ?? 'No expira' }}</dd>
                <dt class="col-sm-4">Código verificación</dt>
                <dd class="col-sm-8">{{ $certificate->verification_code }}</dd>
                <dt class="col-sm-4">Estado</dt>
                <dd class="col-sm-8">
                    @php
                        $isExpired = $certificate->expiry_date && \Carbon\Carbon::parse($certificate->expiry_date)->isPast();
                    @endphp
                    @if($isExpired)
                        <span class="badge bg-danger">Vencido</span>
                    @elseif($certificate->status === 'inactive')
                        <span class="badge bg-secondary">Inactivo</span>
                    @else
                        <span class="badge bg-success">Activo</span>
                    @endif
                </dd>
            </dl>
            <div class="mb-3 text-center">
                <img src="{{ route('certificates.qrcode', $certificate->verification_code) }}" 
                     alt="QR Code" 
                     class="img-fluid" 
                     style="max-width: 200px; height: auto; display: inline-block;"
                     onerror="this.onerror=null; this.src='{{ asset('images/qr-error.png') }}';">
                <p class="mt-2">Escanea para verificar</p>
            </div>
            @if($certificate->file_path ?? false)
                <a href="{{ asset('storage/' . $certificate->file_path) }}" class="btn btn-outline-primary" download>Descargar archivo</a>
            @endif
        </div>
    </div>
</div>
@endsection