<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';
    
    protected $fillable = [
        'id_paciente',
        'id_consultorio',
        'fecha',
        'hora',
        'motivo',
        'estado',
        'confirmada',
        'confirmacion_enviada'
    ];
    
    protected $casts = [
        'fecha' => 'date',
        'hora' => 'datetime:H:i',
        'confirmada' => 'boolean',
        'confirmacion_enviada' => 'boolean'
    ];
    
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }
    
    public function consultorio()
    {
        return $this->belongsTo(Consultorio::class, 'id_consultorio');
    }
    
    /*public function expediente()
    {
        return $this->hasOne(ExpedienteClinico::class, 'id_cita');
    }*/
}