<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'recipient_name',
        'recipient_email',
        'certificate_type',
        'issue_date',
        'expiry_date',
        'issuer_id',
        'verification_code',
        'hash',
        'status',
    ];
    
    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];
    
    /**
     * Relación con el emisor del certificado
     */
    public function issuer()
    {
        return $this->belongsTo(User::class, 'issuer_id');
    }
    
    /**
     * Relación con el historial de cambios
     */
    public function history()
    {
        return $this->hasMany(CertificateHistory::class);
    }
    
    /**
     * Registrar un cambio en el historial
     */
    public function recordChange(string $action, array $changes = [], ?int $user_id = null): void
    {
        $this->history()->create([
            'action' => $action,
            'changes' => $changes,
            'user_id' => $user_id ?? auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}