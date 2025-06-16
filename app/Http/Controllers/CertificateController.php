<?php

namespace App\Http\Controllers;

use App\Http\Requests\CertificateRequest;
use App\Models\Certificate;
use App\Services\CertificateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class CertificateController extends Controller
{
    protected $certificateService;
    
    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
        $this->middleware('auth')->except(['verify', 'checkValidity']);
    }
    
    /**
     * Mostrar lista de certificados
     */
    public function index()
    {
        $certificates = Certificate::with('issuer')->latest()->paginate(10);
        return view('certificates.index', compact('certificates'));
    }
    
    /**
     * Mostrar formulario para crear certificado
     */
    public function create()
    {
        return view('certificates.create');
    }
    
    /**
     * Almacenar nuevo certificado
     */
    public function store(CertificateRequest $request)
    {
        try {
            $certificate = $this->certificateService->createCertificate($request->validated());
            $certificate->recordChange('created');
            
            return redirect()->route('certificates.show', $certificate)
                ->with('success', 'Certificado creado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al guardar certificado', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);
            
            return back()->withInput()->with('error', 'Error al crear el certificado: ' . $e->getMessage());
        }
    }
    
    /**
     * Mostrar certificado
     */
    public function show(Certificate $certificate)
    {
        return view('certificates.show', compact('certificate'));
    }
    
    /**
     * Generate QR code for a certificate.
     *
     * @param string $code The verification code of the certificate.
     * @return \Illuminate\Http\Response
     */
    public function generateQrCode(string $code)
    {
        try {
            $certificate = Certificate::where('verification_code', $code)->first();

            if (!$certificate) {
                Log::warning('QR Code generation failed: Certificate not found for code.', ['code' => $code]);
                abort(404, 'Certificado no encontrado para generar QR.');
            }

            $url = route('certificates.verify', $certificate->verification_code, absolute: true);

            $options = new QROptions([
                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                'eccLevel'   => QRCode::ECC_L,
                'scale'      => 10,
                'quietzone'  => 2,
                'imageBase64' => false,
                'addQuietzone' => true,
                'moduleValues' => [
                    // finder
                    QRCode::M_FINDER_DARK    => '#000000', // dark (true)
                    QRCode::M_FINDER_DOT     => '#000000', // finder dot, dark (true)
                    QRCode::M_FINDER         => '#000000', // finder, dark (true)
                    // alignment
                    QRCode::M_ALIGNMENT_DARK => '#000000', // dark (true)
                    QRCode::M_ALIGNMENT      => '#000000', // alignment, dark (true)
                    // timing
                    QRCode::M_TIMING_DARK    => '#000000', // dark (true)
                    QRCode::M_TIMING         => '#000000', // timing, dark (true)
                    // format
                    QRCode::M_FORMAT_DARK    => '#000000', // dark (true)
                    QRCode::M_FORMAT         => '#000000', // format, dark (true)
                    // version
                    QRCode::M_VERSION_DARK   => '#000000', // dark (true)
                    QRCode::M_VERSION        => '#000000', // version, dark (true)
                    // data
                    QRCode::M_DATA_DARK      => '#000000', // dark (true)
                    QRCode::M_DATA           => '#000000', // data, dark (true)
                    // darkmodule
                    QRCode::M_DARKMODULE     => '#000000', // dark module, dark (true)
                    // separator
                    QRCode::M_SEPARATOR      => '#000000', // separator, dark (true)
                    // quietzone
                    QRCode::M_QUIETZONE      => '#FFFFFF', // quiet zone, light (false)
                ],
            ]);

            $qrcode = (new QRCode($options))->render($url);

            // Ensure we have valid image data
            if (empty($qrcode)) {
                throw new \Exception('QR code generation failed: Empty image data');
            }

            // Set proper headers for PNG image
            return response($qrcode)
                ->header('Content-Type', 'image/png')
                ->header('Cache-Control', 'public, max-age=31536000'); // Cache for 1 year

        } catch (\Exception $e) {
            Log::error('Error generating QR code', [
                'code' => $code,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Return a more user-friendly error response
            return response()->json([
                'error' => 'Error al generar el código QR',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Verificar certificado por código QR
     */
    public function verify(string $code)
    {
        $certificate = $this->certificateService->verifyCertificate($code);
        
        if (!$certificate) {
            return view('certificates.invalid');
        }
        
        // Registrar la verificación en el historial
        $certificate->recordChange('verified', [], null);
        
        return view('certificates.verify', compact('certificate'));
    }
    
    /**
     * Verificar validez del certificado (API)
     */
    public function checkValidity(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);
        
        $certificate = $this->certificateService->verifyCertificate($request->code);
        
        if (!$certificate) {
            return response()->json([
                'valid' => false,
                'message' => 'Certificado no encontrado'
            ], 404);
        }
        
        // Verificar si el certificado ha expirado
        $isExpired = $certificate->expiry_date && now()->greaterThan($certificate->expiry_date);
        
        return response()->json([
            'valid' => !$isExpired,
            'certificate' => [
                'recipient_name' => $certificate->recipient_name,
                'certificate_type' => $certificate->certificate_type,
                'issue_date' => $certificate->issue_date->format('Y-m-d'),
                'expiry_date' => $certificate->expiry_date ? $certificate->expiry_date->format('Y-m-d') : null,
                'status' => $isExpired ? 'expired' : $certificate->status,
            ]
        ]);
    }
}