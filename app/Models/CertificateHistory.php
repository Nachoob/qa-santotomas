<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateHistory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'certificate_id',
        'action',
        'changes',
        'user_id',
        'ip_address',
        'user_agent',
    ];
    
    protected $casts = [
        'changes' => 'array',
    ];
    
    /**
     * Relación con el certificado
     */
    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }
    
    /**
     * Relación con el usuario que realizó el cambio
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}