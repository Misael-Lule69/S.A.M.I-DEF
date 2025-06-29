<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Medico extends Authenticatable
{
    use Notifiable;

    protected $guard = 'medico';

    protected $fillable = [
        'usuario',
        'nombre_completo',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}