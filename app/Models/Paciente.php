<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Paciente extends Authenticatable
{
    use Notifiable;

    protected $guard = 'paciente';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Asegúrate de que la clave primaria sea 'id'
    protected $primaryKey = 'id';
    
    // Si tu tabla tiene un nombre diferente
    protected $table = 'pacientes';
}