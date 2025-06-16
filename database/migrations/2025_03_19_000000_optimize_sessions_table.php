<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            // Verificar si el índice last_activity ya existe
            $indexes = collect(DB::select("SHOW INDEXES FROM sessions"))->pluck('Key_name');
            
            if (!$indexes->contains('sessions_last_activity_index')) {
                $table->index('last_activity');
            }
            
            // Verificar si el índice user_id ya existe
            if (Schema::hasColumn('sessions', 'user_id') && !$indexes->contains('sessions_user_id_index')) {
                $table->index('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            $indexes = collect(DB::select("SHOW INDEXES FROM sessions"))->pluck('Key_name');
            
            if ($indexes->contains('sessions_last_activity_index')) {
                $table->dropIndex(['last_activity']);
            }
            
            if ($indexes->contains('sessions_user_id_index')) {
                $table->dropIndex(['user_id']);
            }
        });
    }
}; 