<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Redirección después de login para pacientes
    protected $redirectTo = '/paciente/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Usar teléfono como campo de login
    public function username()
    {
        return 'telefono';
    }

    // Especificar el guard a usar
    protected function guard()
    {
        return auth()->guard('paciente');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'telefono' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function credentials(Request $request)
    {
        return $request->only('telefono', 'password');
    }
}