<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('expedientes_clinicos', function (Blueprint $table) {
            $table->text('estudios_gabinete')->nullable()->after('resultados_laboratorio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expedientes_clinicos', function (Blueprint $table) {
            $table->dropColumn('estudios_gabinete');
        });
    }
};
