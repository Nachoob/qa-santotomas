<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale', config('app.locale'));
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            session(['locale' => $locale]);
        }
        App::setLocale($locale);
        return $next($request);
    }
} 