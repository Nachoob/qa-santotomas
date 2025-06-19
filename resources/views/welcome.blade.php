@extends('layout')
@section('title', 'Sistema de verificación de certificados')
@section('head')
<style>
    .hero {
        background: #f8fafc;
        padding: 60px 0 40px 0;
    }
    .hero img { max-height: 70px; }
    .icon-step { height: 48px; margin-bottom: 10px; }
    .card-minimal { border-radius: 18px; box-shadow: 0 2px 16px rgba(0,0,0,0.06); }
    .faq-section .accordion-button { font-weight: 500; }
    .footer-link { color: #fff; margin-right: 15px; }
    .footer-link:hover { text-decoration: underline; }
</style>
@endsection
@section('content')
<!-- Hero -->
<section class="hero text-center">
    <h1 class="display-5 fw-bold">Genera y valida tus certificados digitales en segundos</h1>
    <p class="lead mb-4">Seguridad basada en QR, control total de acceso y trazabilidad.</p>
    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Comenzar</a>
    <a href="#faq" class="btn btn-outline-secondary btn-lg ms-2">Ver preguntas frecuentes</a>
</section>

<!-- Resumen de flujo de uso -->
<section class="container py-5">
    <h2 class="text-center mb-4">¿Cómo funciona?</h2>
    <div class="row text-center">
        <div class="col-md-3">
            <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" class="icon-step" alt="Registro">
            <h5 class="mt-2">Regístrate</h5>
            <p>Crea tu cuenta y configura tu perfil.</p>
        </div>
        <div class="col-md-3">
            <img src="https://cdn-icons-png.flaticon.com/512/1828/1828919.png" class="icon-step" alt="Genera">
            <h5 class="mt-2">Genera certificados</h5>
            <p>Sube o crea certificados digitales únicos.</p>
        </div>
        <div class="col-md-3">
            <img src="https://cdn-icons-png.flaticon.com/512/709/709496.png" class="icon-step" alt="Envía">
            <h5 class="mt-2">Envía o comparte</h5>
            <p>Comparte el QR con el destinatario.</p>
        </div>
        <div class="col-md-3">
            <img src="https://cdn-icons-png.flaticon.com/512/565/565547.png" class="icon-step" alt="Valida">
            <h5 class="mt-2">Valida fácilmente</h5>
            <p>Escanea el QR o ingresa el código para validar.</p>
        </div>
    </div>
</section>

<!-- Manual de usuario -->
<section class="container py-4">
    <div class="text-center">
        <a href="{{ asset('docs/USER_MANUAL.pdf') }}" class="btn btn-outline-primary" target="_blank">
            <i class="bi bi-file-earmark-text"></i> Ver manual de usuario
        </a>
    </div>
</section>

<!-- Ventajas y casos de uso -->
<section class="container py-5" style="max-width: 1000px;">
    <h2 class="text-center mb-4">Ventajas y casos de uso</h2>
    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Ideal para instituciones</h5>
                    <p class="card-text">Colegios, eventos, entidades públicas y privadas.</p>
                    <ul class="text-start small">
                        <li>Control de acceso a eventos</li>
                        <li>Certificados académicos</li>
                        <li>Validación de membresías</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Cumple con estándares</h5>
                    <p class="card-text">Firma electrónica, validación offline y trazabilidad.</p>
                    <ul class="text-start small">
                        <li>QR único y seguro</li>
                        <li>Historial de validaciones</li>
                        <li>Soporte para normativas nacionales</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Fácil de usar</h5>
                    <p class="card-text">No requiere equipos especiales, solo tu cámara o smartphone.</p>
                    <ul class="text-start small">
                        <li>Interfaz intuitiva</li>
                        <li>Validación en segundos</li>
                        <li>Soporte multiplataforma</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="container py-5 faq-section" id="faq">
    <h2 class="text-center mb-4">Preguntas frecuentes</h2>
    <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq1">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                    ¿Necesito equipo especial para validar?
                </button>
            </h2>
            <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    No, solo necesitas una cámara o smartphone con acceso a internet.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                    ¿Cómo se protege la clave privada?
                </button>
            </h2>
            <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    La clave privada se almacena cifrada y solo el propietario tiene acceso a ella.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq3">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                    ¿Puedo revocar un certificado?
                </button>
            </h2>
            <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Sí, puedes revocar certificados desde tu panel de administración.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq4">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                    ¿Qué pasa si pierdo mi acceso?
                </button>
            </h2>
            <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Puedes restablecer tu contraseña usando tu correo electrónico registrado.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonios o cifras -->
<section class="container py-5">
    <div class="row text-center">
        <div class="col-md-6">
            <h3>+200 organizaciones confían en nosotros</h3>
        </div>
        <div class="col-md-6">
            <h3>+1.000 certificados emitidos este mes</h3>
        </div>
    </div>
</section>

<!-- Equipo y contacto -->
<section class="container py-5" id="quienes-somos">
    <h2 class="text-center mb-4">¿Quiénes somos?</h2>
    <p class="text-center">Somos estudiantes de Ingeniería en Informática de Santo Tomás, comprometidos con la innovación y la seguridad digital. Este proyecto es parte de nuestro trabajo académico y busca aportar soluciones tecnológicas reales a la gestión y validación de certificados digitales.</p>
</section>
@endsection

@section('footer')
<style>
    .footer-curved {
        background: #212529;
        color: #fff;
        width: 70%;
        margin: 40px auto 0 auto;
        border-top-left-radius: 60px 40px;
        border-top-right-radius: 60px 40px;
        box-shadow: 0 -2px 16px rgba(0,0,0,0.08);
        padding: 32px 24px 18px 24px;
    }
    .footer-curved nav a {
        color: #fff;
        margin: 0 18px;
        text-decoration: none;
        font-weight: 500;
    }
    .footer-curved nav a:hover {
        text-decoration: underline;
    }
    .footer-curved .footer-logo {
        height: 48px;
        margin-bottom: 8px;
    }
</style>
<footer class="footer-curved text-center">
    <img src="{{ asset('logo.png') }}" alt="Logo QA" class="footer-logo">
    <nav class="mb-2">
        <a href="/">Inicio</a>
        <a href="#quienes-somos">Quiénes somos</a>
        <a href="{{ asset('docs/USER_MANUAL.pdf') }}" target="_blank">Manual de usuario</a>
        <a href="#faq">Preguntas frecuentes</a>
    </nav>
    <div class="mb-2">
        <a href="mailto:soporte@santotomas.cl" class="text-white text-decoration-none"><i class="bi bi-envelope"></i> soporte@santotomas.cl</a>
    </div>
    <div class="small text-white-50 text-center">
        &copy; {{ date('Y') }} QA Santo Tomás. Todos los derechos reservados.
    </div>
</footer>
@endsection
