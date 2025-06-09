<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Redirige la ruta raíz al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación (dependiendo de si usas Laravel UI, Breeze o Fortify)


// O si usas Fortify/Breeze con controladores personalizados:
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    });