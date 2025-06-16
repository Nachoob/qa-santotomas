<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class CacheController extends Controller
{
    public function clear()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('config:cache');
        Artisan::call('optimize:clear');

        return response('<pre>' . Artisan::output() . "\n✓ Todas las caches han sido limpiadas y regeneradas.</pre>");
    }
} 