<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_name');
            $table->string('recipient_email');
            $table->string('certificate_type');
            $table->date('issue_date');
            $table->date('expiry_date')->nullable();
            $table->foreignId('issuer_id')->constrained('users');
            $table->string('verification_code')->unique();
            $table->string('hash');
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('certificate_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_id')->constrained()->onDelete('cascade');
            $table->string('action');
            $table->json('changes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_histories');
        Schema::dropIfExists('certificates');
    }
};