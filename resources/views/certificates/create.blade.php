@extends('layout')
@section('title', 'Generar/Registrar Certificado')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-minimal p-4">
            <h3 class="mb-4">Generar/Registrar Certificado</h3>
            <p class="text-muted mb-4">Completa el siguiente formulario para registrar un nuevo certificado en el sistema. Asegúrate de ingresar correctamente los datos del destinatario y adjuntar el archivo correspondiente.</p>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('certificates.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nombre del destinatario</label>
                    <input type="text" name="recipient_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email del destinatario</label>
                    <input type="email" name="recipient_email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipo de certificado</label>
                    <select name="certificate_type" class="form-control" required>
                        <option value="">Seleccione un tipo</option>
                        <option value="course">Curso</option>
                        <option value="achievement">Logro</option>
                        <option value="participation">Participación</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Archivo certificado (PDF/JPG/PNG)</label>
                    <input type="file" name="certificate_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <div class="mb-3">
                    <label class="form-label">Fecha de emisión</label>
                    <input type="date" name="issue_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fecha de expiración</label>
                    <input type="date" name="expiry_date" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary w-100">Registrar certificado</button>
            </form>
        </div>
    </div>
</div>
@endsection 