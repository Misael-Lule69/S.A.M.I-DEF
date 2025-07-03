<?php

namespace Database\Seeders;

use App\Models\Medico;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MedicoSeeder extends Seeder
{
    public function run()
{
    \App\Models\User::create([
        'name' => 'Maricela Mayorga',
        'email' => 'maricela@gmail.com',
        'password' => bcrypt('12345678'),
        // otros campos necesarios
    ]);
    
    // Puedes agregar más médicos aquí
}
}