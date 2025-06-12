<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CertificateTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $certificate;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a test user
        $this->user = User::factory()->create();
        
        // Create a test certificate
        $this->certificate = Certificate::create([
            'recipient_name' => 'John Doe',
            'recipient_email' => 'john@example.com',
            'certificate_type' => 'Test Certificate',
            'issue_date' => now(),
            'expiry_date' => now()->addYear(),
            'issuer_id' => $this->user->id,
            'verification_code' => 'TEST123',
            'hash' => 'test_hash',
            'status' => 'active'
        ]);
    }

    /** @test */
    public function it_can_verify_a_valid_certificate()
    {
        $response = $this->get(route('certificates.verify', $this->certificate->verification_code));
        
        $response->assertStatus(200)
                ->assertViewIs('certificates.verify')
                ->assertViewHas('certificate');
    }

    /** @test */
    public function it_returns_404_for_invalid_certificate()
    {
        $response = $this->get(route('certificates.verify', 'INVALID_CODE'));
        
        $response->assertStatus(404)
                ->assertViewIs('certificates.invalid');
    }

    /** @test */
    public function it_validates_certificate_creation_input()
    {
        $response = $this->actingAs($this->user)
                        ->post(route('certificates.store'), [
                            'recipient_name' => '',
                            'recipient_email' => 'invalid-email',
                            'certificate_type' => '',
                        ]);

        $response->assertSessionHasErrors(['recipient_name', 'recipient_email', 'certificate_type']);
    }

    /** @test */
    public function it_creates_certificate_history_on_verification()
    {
        $this->get(route('certificates.verify', $this->certificate->verification_code));
        
        $this->assertDatabaseHas('certificate_histories', [
            'certificate_id' => $this->certificate->id,
            'action' => 'verified'
        ]);
    }

    /** @test */
    public function it_checks_certificate_validity_via_api()
    {
        $response = $this->postJson('/api/certificates/check-validity', [
            'code' => $this->certificate->verification_code
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'valid' => true,
                    'certificate' => [
                        'recipient_name' => 'John Doe',
                        'certificate_type' => 'Test Certificate'
                    ]
                ]);
    }
}