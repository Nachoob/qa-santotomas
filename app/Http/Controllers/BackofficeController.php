<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;

class BackofficeController extends Controller
{
    public function index(Request $request)
    {
        $certificates = Certificate::latest()->paginate(10);
        return view('backoffice.index', compact('certificates'));
    }
} 