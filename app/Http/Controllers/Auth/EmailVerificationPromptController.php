<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->user()->hasVerifiedEmail()
                    ? ($request->user()->is_admin ? redirect()->intended(route('admin.index', absolute: false)) : redirect()->intended(route('welcome', absolute: false)))
                    : view('auth.verify-email');
    }
}
