<?php

namespace App\Services;

use App\Models\Certificate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CertificateService
{
    /**
     * Crear un nuevo certificado
     */
    public function createCertificate(array $data): Certificate
    {
        try {
            $data['verification_code'] = $this->generateVerificationCode();
            $data['hash'] = $this->generateHash($data);
            
            $certificate = Certificate::create($data);
            
            Log::info('Certificado creado exitosamente', [
                'certificate_id' => $certificate->id,
                'recipient' => $certificate->recipient_name,
                'created_by' => auth()->id() ?? 'sistema',
            ]);
            
            return $certificate;
        } catch (\Exception $e) {
            Log::error('Error al crear certificado', [
                'error' => $e->getMessage(),
                'data' => $data,
                'trace' => $e->getTraceAsString(),
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Verificar un certificado por su código
     */
    public function verifyCertificate(string $code): ?Certificate
    {
        try {
            $certificate = Certificate::where('verification_code', $code)->first();
            
            if (!$certificate) {
                Log::warning('Intento de verificación de certificado inválido', [
                    'code' => $code,
                    'ip' => request()->ip(),
                ]);
                return null;
            }
            
            Log::info('Certificado verificado exitosamente', [
                'certificate_id' => $certificate->id,
                'verification_code' => $code,
                'ip' => request()->ip(),
            ]);
            
            return $certificate;
        } catch (\Exception $e) {
            Log::error('Error al verificar certificado', [
                'code' => $code,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Generar código de verificación único
     */
    private function generateVerificationCode(): string
    {
        return Str::uuid()->toString();
    }
    
    /**
     * Generar hash para el certificado
     */
    private function generateHash(array $data): string
    {
        $hashData = $data['recipient_name'] . $data['recipient_email'] . 
                   $data['certificate_type'] . $data['issue_date'] . 
                   ($data['expiry_date'] ?? '') . $data['issuer_id'];
                   
        return hash('sha256', $hashData);
    }
}