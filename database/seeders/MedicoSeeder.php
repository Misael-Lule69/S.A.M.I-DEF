<?php

namespace Database\Seeders;

use App\Models\Medico;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MedicoSeeder extends Seeder
{
    public function run()
    {
        Medico::create([
            'usuario' => 'Maricela',
            'password' => Hash::make('12345678'),
            'nombre_completo' => 'Maricela Mayorga'
        ]);
    }
}