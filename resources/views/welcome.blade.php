@extends('layout')
@section('title', 'Sistema de verificación de certificados')
@section('head')
<style>
    .home-intro {
        max-width: 600px;
        margin: 40px auto 60px auto;
        text-align: center;
    }
    .card-minimal {
        border-radius: 18px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    }
</style>
@endsection
@section('content')
<div class="home-intro">
    <h2 class="fw-bold mb-3">Bienvenido al sistema de verificación de certificados</h2>
    <p class="lead">Este sistema te permite subir, generar y verificar certificados digitales de manera rápida y segura. Puedes verificar la autenticidad de un certificado escaneando su código QR o ingresando el código manualmente.</p>
</div>
@auth
<div class="row justify-content-center g-4">
    <div class="col-md-5 d-none">
        <div class="card card-minimal p-4">
            <h4 class="mb-3">Subir certificados</h4>
            <form id="uploadForm" class="row g-3">
                <div class="col-12">
                    <label class="form-label">Archivo certificado</label>
                    <input type="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Detalles certificado</label>
                    <input type="text" class="form-control" placeholder="Certificate ID" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary w-100">Generar código QR</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-5 mx-auto">
        <div class="card card-minimal p-4">
            <h4 class="mb-3">Verificar certificado</h4>
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
                    <div class="mb-3">
                        <label class="form-label">Verificación de código</label>
                        <input type="text" id="verificationCode" class="form-control" placeholder="Enter certificate code">
                    </div>
                    <button id="verifyManual" class="btn btn-primary w-100">Verificar certificado</button>
                </div>
            </div>
            <div id="result" class="alert alert-info mt-3 d-none">
                <h5 class="mb-2">Resultado de la verificación</h5>
                <p id="verificationText"></p>
            </div>
        </div>
    </div>
</div>
@endauth
@endsection
@section('scripts')
@auth
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let html5QrcodeScanner = null;
    let isScanning = false;

    // Bootstrap tab switching is automatic

    // Scanner functionality
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
                { 
                    fps: 10, 
                    qrbox: {width: 250, height: 250},
                    aspectRatio: 1.0
                },
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
        verifyCertificate(decodedText);
    }

    function onScanFailure(error) {
        // Opcional: mostrar error
    }

    // Manual verification
    document.getElementById('verifyManual').addEventListener('click', function() {
        const code = document.getElementById('verificationCode').value;
        if (code) {
            verifyCertificate(code);
        } else {
            Swal.fire({
                title: 'Error',
                text: 'Por favor ingresa un código de verificación',
                icon: 'error'
            });
        }
    });

    function verifyCertificate(code) {
        document.getElementById('result').classList.remove('d-none');
        document.getElementById('verificationText').textContent = 'Verificando certificado...';

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
                document.getElementById('verificationText').textContent = 'Certificado válido y encontrado.';
            } else {
                Swal.fire({
                    title: 'Certificado Inválido',
                    text: data.message || 'El certificado no es válido o ha expirado.',
                    icon: 'error'
                });
                document.getElementById('verificationText').textContent = data.message || 'Certificado no válido.';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error de Conexión',
                text: 'No se pudo verificar el certificado. Inténtalo de nuevo.',
                icon: 'error'
            });
            document.getElementById('verificationText').textContent = 'Error al verificar el certificado.';
        });
    }

    // Handle form submission
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Procesando...',
            text: 'Generando código QR para tu certificado',
            icon: 'info',
            showConfirmButton: false,
            timer: 2000
        });
    });
</script>
@endauth
@endsection
