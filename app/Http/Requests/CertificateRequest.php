<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'recipient_name' => 'required|string|max:255',
            'recipient_email' => 'required|email|max:255',
            'certificate_type' => 'required|string|in:course,achievement,participation',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:issue_date',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'recipient_name.required' => 'El nombre del destinatario es obligatorio',
            'recipient_email.required' => 'El correo electrónico del destinatario es obligatorio',
            'recipient_email.email' => 'El correo electrónico debe tener un formato válido',
            'certificate_type.required' => 'El tipo de certificado es obligatorio',
            'certificate_type.in' => 'El tipo de certificado debe ser válido',
            'issue_date.required' => 'La fecha de emisión es obligatoria',
            'issue_date.date' => 'La fecha de emisión debe ser una fecha válida',
            'expiry_date.date' => 'La fecha de expiración debe ser una fecha válida',
            'expiry_date.after' => 'La fecha de expiración debe ser posterior a la fecha de emisión',
        ];
    }
}