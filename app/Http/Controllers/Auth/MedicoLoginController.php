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
            'email' => 'required|email', // Cambiar de 'usuario' a 'email'
            'password' => 'required|string',
        ]);

        if (Auth::guard('medico')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->remember)) {
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas.',
        ]);
    }

    public function logout()
    {
        Auth::guard('medico')->logout();
        return redirect('/medico/login');
    }
}