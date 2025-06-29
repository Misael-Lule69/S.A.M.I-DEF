<?php

// database/migrations/xxxx_xx_xx_xxxxxx_modify_pacientes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPacientesTable extends Migration
{
    public function up()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            // Cambiar campo telefono para asegurar unicidad
            $table->string('telefono', 20)->unique()->change();
            
            // Asegurar que la contraseña tenga suficiente longitud para hashing
            $table->string('password', 255)->change();
            
            // Agregar campos para "remember token" (opcional pero recomendado)
            $table->rememberToken()->after('password');
            
            // Agregar timestamps si no existen
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            // Revertir los cambios si es necesario
            $table->dropUnique(['telefono']);
            $table->string('telefono', 20)->change();
            $table->string('password', 100)->change();
            $table->dropRememberToken();
            $table->dropTimestamps();
        });
    }
}