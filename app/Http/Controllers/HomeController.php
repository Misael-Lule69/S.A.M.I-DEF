<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:medico');
    }

    public function index()
    {
        // Solo médicos pueden acceder aquí
        return view('home');
    }
}