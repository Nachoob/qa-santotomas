@extends('layout')
@section('title', 'Panel de Administración')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2>Panel de Administración</h2>
        <div class="d-flex align-items-center gap-3">
            <form method="POST" action="#" class="d-inline">
                @csrf
                <label class="form-label me-2">Tema:</label>
                <select class="form-select d-inline w-auto" name="theme" onchange="document.body.setAttribute('data-bs-theme', this.value)">
                    <option value="light">Claro</option>
                    <option value="dark">Oscuro</option>
                </select>
            </form>
            <form method="POST" action="#" class="d-inline">
                @csrf
                <label class="form-label me-2">Color principal:</label>
                <input type="color" name="main_color" value="#0d6efd" onchange="document.documentElement.style.setProperty('--bs-primary', this.value)">
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card card-minimal p-4">
            <h4 class="mb-3">Certificados registrados</h4>
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
            {{ $certificates->links() }}
        </div>
    </div>
</div>
@endsection