<?php

// database/migrations/xxxx_xx_xx_xxxxxx_modify_medicos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyMedicosTable extends Migration
{
    public function up()
    {
        Schema::table('medicos', function (Blueprint $table) {
            // Asegurar que el usuario sea único
            $table->string('usuario', 100)->unique()->change();
            
            // Asegurar longitud adecuada para contraseña hasheada
            $table->string('password', 255)->change();
            
            // Agregar remember token
            $table->rememberToken();
            
            // Agregar timestamps si no existen
            $table->timestamps();
            
            // Opcional: agregar más campos de información del médico
            $table->string('nombre_completo')->after('usuario');
        });
    }

    public function down()
    {
        Schema::table('medicos', function (Blueprint $table) {
            $table->dropUnique(['usuario']);
            $table->string('usuario', 100)->change();
            $table->string('password', 100)->change();
            $table->dropRememberToken();
            $table->dropTimestamps();
            $table->dropColumn('nombre_completo');
        });
    }
}