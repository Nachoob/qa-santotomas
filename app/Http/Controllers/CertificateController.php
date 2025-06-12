<?php

namespace App\Http\Controllers;

use App\Http\Requests\CertificateRequest;
use App\Models\Certificate;
use App\Services\CertificateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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