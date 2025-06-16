@extends('layout')
@section('title', 'Verificar Certificado')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-minimal p-4">
            <h3 class="mb-4">Verificar Certificado</h3>
            <ul class="nav nav-tabs mb-3" id="verifyTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="scanner-tab" data-bs-toggle="tab" data-bs-target="#scanner-section" type="button" role="tab">Scanner</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual-section" type="button" role="tab">Entrada manual</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="scanner-section" role="tabpanel">
                    <div id="reader" class="w-100 mb-3"></div>
                    <button id="startScanner" class="btn btn-success w-100">Iniciar Scanner</button>
                </div>
                <div class="tab-pane fade" id="manual-section" role="tabpanel">
                    <form method="POST" action="{{ route('certificates.checkValidity') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Código de verificación</label>
                            <input type="text" name="code" class="form-control" placeholder="Ingrese el código" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Verificar certificado</button>
                    </form>
                </div>
            </div>
            @if(session('result'))
                <div class="alert alert-info mt-3">
                    {{ session('result') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    let html5QrcodeScanner = null;
    let isScanning = false;
    document.getElementById('startScanner').addEventListener('click', function() {
        if (!isScanning) {
            startScanner();
        } else {
            stopScanner();
        }
    });
    function startScanner() {
        if (!html5QrcodeScanner) {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader",
                { fps: 10, qrbox: {width: 250, height: 250}, aspectRatio: 1.0 },
                false
            );
        }
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        isScanning = true;
        document.getElementById('startScanner').textContent = 'Detener Scanner';
        document.getElementById('startScanner').classList.remove('btn-success');
        document.getElementById('startScanner').classList.add('btn-danger');
    }
    function stopScanner() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear();
        }
        isScanning = false;
        document.getElementById('startScanner').textContent = 'Iniciar Scanner';
        document.getElementById('startScanner').classList.remove('btn-danger');
        document.getElementById('startScanner').classList.add('btn-success');
    }
    function onScanSuccess(decodedText, decodedResult) {
        stopScanner();
        window.location.href = `{{ url('/verify') }}/${decodedText}`;
    }
    function onScanFailure(error) {}
</script>
@endsection 