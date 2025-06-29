<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicoLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.medico-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('medico')->attempt([
            'usuario' => $request->usuario,
            'password' => $request->password
        ], $request->remember)) {
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'usuario' => 'Credenciales incorrectas.',
        ]);
    }

    public function logout()
{
    Auth::guard('medico')->logout();
    return redirect('/medico/login');  // Redirige al login de médico
}
}