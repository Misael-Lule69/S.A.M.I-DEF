<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpedienteClinico;
use App\Models\Cita;
use App\Models\Paciente;
use Carbon\Carbon;

class ExpedienteClinicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si hay citas y pacientes
        $citas = Cita::where('estado', 'confirmada')->get();
        $pacientes = Paciente::all();

        if ($citas->isEmpty() || $pacientes->isEmpty()) {
            $this->command->info('No hay citas confirmadas o pacientes disponibles para crear expedientes.');
            return;
        }

        $expedientes = [
            [
                'id_cita' => $citas->first()->id,
                'fecha_elaboracion' => Carbon::now()->subDays(5),
                'hora_elaboracion' => '09:30:00',
                'tipo_interrogatorio' => 'Consulta General',
                'nombre_paciente' => $pacientes->first()->nombre . ' ' . $pacientes->first()->apellido_paterno,
                'edad' => 35,
                'genero' => 'Femenino',
                'domicilio' => 'Calle Principal #123, Colonia Centro',
                'ocupacion' => 'Maestra',
                'parentesco_1' => 'Esposo',
                'parentesco_2' => 'Hijos',
                'antecedentes_heredo_familiares' => 'Diabetes en abuela materna',
                'antecedentes_personales_no_patologicos' => 'Alergia a penicilina',
                'antecedentes_perinatales' => 'Nacimiento normal a término',
                'alimentacion' => 'Regular, 3 comidas al día',
                'inmunizaciones' => 'Esquema completo',
                'desarrollo_psicomotor' => 'Normal',
                'antecedentes_personales_patologicos' => 'Hipertensión arterial',
                'padecimiento_actual' => 'Dolor de cabeza intenso de 3 días de evolución, acompañado de náuseas y fotofobia',
                'interrogatorio_cardiovascular' => 'Sin alteraciones',
                'interrogatorio_respiratorio' => 'Sin alteraciones',
                'interrogatorio_gastrointestinal' => 'Náuseas ocasionales',
                'interrogatorio_genitourinario' => 'Sin alteraciones',
                'interrogatorio_hematolinfatico' => 'Sin alteraciones',
                'interrogatorio_nervioso' => 'Cefalea frontal',
                'interrogatorio_musculo_esqueletico' => 'Sin alteraciones',
                'interrogatorio_piel_mucosas' => 'Sin alteraciones',
                'signos_ta' => '140/90',
                'signos_temp' => '36.8',
                'signos_frec_c' => '78',
                'signos_frec_r' => '16',
                'signos_peso' => '65',
                'signos_talla' => '1.65',
                'exploracion_habitus' => 'Consciente, orientada, hidratada',
                'exploracion_cabeza' => 'Normocefálica, sin lesiones',
                'exploracion_cuello' => 'Sin adenopatías',
                'exploracion_torax' => 'Simétrico, buena expansión',
                'exploracion_abdomen' => 'Blando, depresible, sin dolor',
                'exploracion_genitales' => 'No explorado',
                'exploracion_extremidades' => 'Sin edema, pulsos presentes',
                'exploracion_piel' => 'Normocoloreada, sin lesiones',
                'resultados_laboratorio' => 'Hemoglobina: 14 g/dL, Glucosa: 95 mg/dL',
                'diagnosticos' => 'Cefalea tensional',
                'tratamiento' => 'Paracetamol 500mg cada 6 horas por 3 días. Reposo y evitar estrés.',
                'pronostico' => 'Favorable con tratamiento'
            ],
            [
                'id_cita' => $citas->count() > 1 ? $citas->get(1)->id : $citas->first()->id,
                'fecha_elaboracion' => Carbon::now()->subDays(2),
                'hora_elaboracion' => '14:15:00',
                'tipo_interrogatorio' => 'Consulta de Seguimiento',
                'nombre_paciente' => $pacientes->count() > 1 ? $pacientes->get(1)->nombre . ' ' . $pacientes->get(1)->apellido_paterno : $pacientes->first()->nombre . ' ' . $pacientes->first()->apellido_paterno,
                'edad' => 28,
                'genero' => 'Masculino',
                'domicilio' => 'Avenida Reforma #456, Colonia Norte',
                'ocupacion' => 'Ingeniero',
                'parentesco_1' => 'Padre',
                'parentesco_2' => 'Hermano',
                'antecedentes_heredo_familiares' => 'Hipertensión en padre',
                'antecedentes_personales_no_patologicos' => 'Alergia a mariscos',
                'antecedentes_perinatales' => 'Nacimiento normal',
                'alimentacion' => 'Irregular, muchas comidas fuera de casa',
                'inmunizaciones' => 'Esquema completo',
                'desarrollo_psicomotor' => 'Normal',
                'antecedentes_personales_patologicos' => 'Gastritis crónica',
                'padecimiento_actual' => 'Dolor abdominal en epigastrio de 1 semana, ardor y reflujo',
                'interrogatorio_cardiovascular' => 'Sin alteraciones',
                'interrogatorio_respiratorio' => 'Sin alteraciones',
                'interrogatorio_gastrointestinal' => 'Dolor epigástrico, ardor, reflujo',
                'interrogatorio_genitourinario' => 'Sin alteraciones',
                'interrogatorio_hematolinfatico' => 'Sin alteraciones',
                'interrogatorio_nervioso' => 'Sin alteraciones',
                'interrogatorio_musculo_esqueletico' => 'Sin alteraciones',
                'interrogatorio_piel_mucosas' => 'Sin alteraciones',
                'signos_ta' => '120/80',
                'signos_temp' => '37.0',
                'signos_frec_c' => '72',
                'signos_frec_r' => '18',
                'signos_peso' => '75',
                'signos_talla' => '1.75',
                'exploracion_habitus' => 'Consciente, orientado, hidratado',
                'exploracion_cabeza' => 'Normocefálico',
                'exploracion_cuello' => 'Sin adenopatías',
                'exploracion_torax' => 'Simétrico',
                'exploracion_abdomen' => 'Dolor a la palpación en epigastrio',
                'exploracion_genitales' => 'No explorado',
                'exploracion_extremidades' => 'Sin edema',
                'exploracion_piel' => 'Normocoloreada',
                'resultados_laboratorio' => 'Hemograma normal, función hepática normal',
                'diagnosticos' => 'Gastritis aguda',
                'tratamiento' => 'Omeprazol 20mg cada 12 horas por 7 días. Dieta blanda. Evitar irritantes.',
                'pronostico' => 'Favorable con tratamiento y cambios en hábitos alimenticios'
            ]
        ];

        foreach ($expedientes as $expediente) {
            // Verificar que no exista ya un expediente para esta cita
            $existe = ExpedienteClinico::where('id_cita', $expediente['id_cita'])->exists();
            if (!$existe) {
                ExpedienteClinico::create($expediente);
            }
        }

        $this->command->info('Expedientes clínicos creados exitosamente.');
    }
}
