@extends('layout')
@section('title', 'Verificar Certificado')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-minimal p-4">
            <h3 class="mb-4">Verificar Certificado</h3>
            <p class="text-muted mb-4">Puedes verificar la validez de un certificado escaneando su código QR o ingresando manualmente el código de verificación proporcionado en el documento.</p>
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
                    <form id="manualVerifyForm" method="POST" action="#">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Código de verificación</label>
                            <input type="text" name="code" id="manualCode" class="form-control" placeholder="Ingrese el código" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Verificar certificado</button>
                    </form>
                </div>
            </div>
            <div id="result" class="alert alert-info mt-3 d-none">
                <h5 class="mb-2">Resultado de la verificación</h5>
                <p id="verificationText"></p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let html5QrcodeScanner = null;
    let isScanning = false;
    document.getElementById('startScanner')?.addEventListener('click', function() {
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
        let code = decodedText;
        if (code.startsWith('http')) {
            let parts = code.split('/');
            code = parts[parts.length - 1];
        }
        verifyCertificateAjax(code);
    }
    function onScanFailure(error) {}

    // Verificación manual por AJAX
    document.getElementById('manualVerifyForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const code = document.getElementById('manualCode').value;
        if (code) {
            verifyCertificateAjax(code);
        } else {
            Swal.fire({
                title: 'Error',
                text: 'Por favor ingresa un código de verificación',
                icon: 'error'
            });
        }
    });

    function verifyCertificateAjax(code) {
        Swal.fire({
            title: 'Verificando...',
            text: 'Consultando validez del certificado',
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => { Swal.showLoading(); }
        });
        fetch('{{ route('certificates.checkValidity') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ code: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                Swal.fire({
                    title: '¡Certificado Válido!',
                    html: `<p><strong>Nombre:</strong> ${data.certificate.recipient_name}</p>
                           <p><strong>Tipo:</strong> ${data.certificate.certificate_type}</p>
                           <p><strong>Fecha de Emisión:</strong> ${data.certificate.issue_date}</p>
                           ${data.certificate.expiry_date ? `<p><strong>Fecha de Expiración:</strong> ${data.certificate.expiry_date}</p>` : ''}
                           <p><strong>Estado:</strong> ${data.certificate.status}</p>`,
                    icon: 'success'
                });
            } else {
                Swal.fire({
                    title: 'Certificado Inválido',
                    text: data.message || 'El certificado no es válido o ha expirado.',
                    icon: 'error'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error de Conexión',
                text: 'No se pudo verificar el certificado. Inténtalo de nuevo.',
                icon: 'error'
            });
        });
    }
</script>
@endsection 