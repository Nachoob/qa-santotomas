<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BackofficeController extends Controller
{
    public function index(Request $request)
    {
        $usersCount = User::count();
        $adminsCount = User::where('is_admin', 1)->count();
        $certificatesCount = \App\Models\Certificate::count();
        return view('backoffice.index', compact('usersCount', 'adminsCount', 'certificatesCount'));
    }

    public function users()
    {
        $users = User::paginate(10);
        return view('backoffice.users', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('backoffice.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'is_admin' => 'required|boolean',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_admin = $request->is_admin;
        $user->save();
        Log::info('Usuario editado por admin', ['admin_id' => auth()->id(), 'user_id' => $user->id]);
        return redirect()->route('admin.users')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->id == auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }
        $user->delete();
        Log::info('Usuario eliminado por admin', ['admin_id' => auth()->id(), 'user_id' => $user->id]);
        return redirect()->route('admin.users')->with('success', 'Usuario eliminado correctamente.');
    }

    public function searchUsers(Request $request)
    {
        $query = $request->input('q');
        $users = User::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->paginate(10);
        return view('backoffice.users', compact('users', 'query'));
    }

    public function certificates()
    {
        $certificates = \App\Models\Certificate::with('issuer')->latest()->paginate(10);
        return view('backoffice.certificates', compact('certificates'));
    }

    public function destroyCertificate($id)
    {
        $certificate = \App\Models\Certificate::findOrFail($id);
        $certificate->delete();
        Log::info('Certificado eliminado por admin', ['admin_id' => auth()->id(), 'certificate_id' => $id]);
        return redirect()->route('admin.certificates')->with('success', 'Certificado eliminado correctamente.');
    }
} 