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
            $table->unsignedBigInteger('id_paciente')->nullable()->after('id');
            // Si quieres la relación foránea, descomenta la siguiente línea:
            // $table->foreign('id_paciente')->references('id')->on('pacientes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expedientes_clinicos', function (Blueprint $table) {
            // Si agregaste la relación foránea, descomenta la siguiente línea:
            // $table->dropForeign(['id_paciente']);
            $table->dropColumn('id_paciente');
        });
    }
};
