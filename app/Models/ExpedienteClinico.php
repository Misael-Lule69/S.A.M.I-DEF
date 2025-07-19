<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpedienteClinico extends Model
{
    protected $table = 'expedientes_clinicos';
    
    // Deshabilitar timestamps automáticos
    public $timestamps = false;
    
    protected $fillable = [
        'id_paciente',
        'id_cita',
        'fecha_elaboracion',
        'hora_elaboracion',
        'fecha_atencion',
        'numero_visita',
        'tipo_interrogatorio',
        'nombre_paciente',
        'edad',
        'genero',
        'domicilio',
        'ocupacion',
        'parentesco_1',
        'parentesco_2',
        'antecedentes_heredo_familiares',
        'antecedentes_personales_no_patologicos',
        'antecedentes_perinatales',
        'alimentacion',
        'inmunizaciones',
        'desarrollo_psicomotor',
        'antecedentes_personales_patologicos',
        'padecimiento_actual',
        'padecimientos_adicionales',
        'interrogatorio_cardiovascular',
        'interrogatorio_respiratorio',
        'interrogatorio_gastrointestinal',
        'interrogatorio_genitourinario',
        'interrogatorio_hematolinfatico',
        'interrogatorio_nervioso',
        'interrogatorio_musculo_esqueletico',
        'interrogatorio_piel_mucosas',
        'signos_ta',
        'signos_temp',
        'signos_frec_c',
        'signos_frec_r',
        'signos_peso',
        'signos_talla',
        'exploracion_habitus',
        'exploracion_cabeza',
        'exploracion_cuello',
        'exploracion_torax',
        'exploracion_abdomen',
        'exploracion_genitales',
        'exploracion_extremidades',
        'exploracion_piel',
        'resultados_laboratorio',
        'estudios_gabinete',
        'diagnosticos',
        'tratamiento',
        'pronostico'
    ];
    
    protected $casts = [
        'fecha_elaboracion' => 'date',
        'hora_elaboracion' => 'datetime:H:i',
        'edad' => 'integer',
        'padecimientos_adicionales' => 'array'
    ];
    
    public function cita()
    {
        return $this->belongsTo(Cita::class, 'id_cita');
    }
    
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_cita', 'id');
    }
} 