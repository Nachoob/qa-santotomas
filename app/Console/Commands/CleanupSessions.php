<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupSessions extends Command
{
    protected $signature = 'sessions:cleanup';
    protected $description = 'Clean up expired sessions from the database';

    public function handle()
    {
        $expired = DB::table('sessions')
            ->where('last_activity', '<', now()->subMinutes(config('session.lifetime')))
            ->delete();

        $this->info("Cleaned up {$expired} expired sessions.");
    }
} 