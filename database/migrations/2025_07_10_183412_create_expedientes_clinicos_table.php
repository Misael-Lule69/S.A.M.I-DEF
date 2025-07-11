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
        Schema::create('expedientes_clinicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cita');
            $table->date('fecha_elaboracion')->nullable();
            $table->time('hora_elaboracion')->nullable();
            $table->text('tipo_interrogatorio')->nullable();
            $table->string('nombre_paciente', 255)->nullable();
            $table->integer('edad')->nullable();
            $table->string('genero', 20)->nullable();
            $table->text('domicilio')->nullable();
            $table->text('ocupacion')->nullable();
            $table->text('parentesco_1')->nullable();
            $table->text('parentesco_2')->nullable();
            $table->text('antecedentes_heredo_familiares')->nullable();
            $table->text('antecedentes_personales_no_patologicos')->nullable();
            $table->text('antecedentes_perinatales')->nullable();
            $table->text('alimentacion')->nullable();
            $table->text('inmunizaciones')->nullable();
            $table->text('desarrollo_psicomotor')->nullable();
            $table->text('antecedentes_personales_patologicos')->nullable();
            $table->text('padecimiento_actual')->nullable();
            $table->text('interrogatorio_cardiovascular')->nullable();
            $table->text('interrogatorio_respiratorio')->nullable();
            $table->text('interrogatorio_gastrointestinal')->nullable();
            $table->text('interrogatorio_genitourinario')->nullable();
            $table->text('interrogatorio_hematolinfatico')->nullable();
            $table->text('interrogatorio_nervioso')->nullable();
            $table->text('interrogatorio_musculo_esqueletico')->nullable();
            $table->text('interrogatorio_piel_mucosas')->nullable();
            $table->string('signos_ta', 10)->nullable();
            $table->string('signos_temp', 10)->nullable();
            $table->string('signos_frec_c', 10)->nullable();
            $table->string('signos_frec_r', 10)->nullable();
            $table->string('signos_peso', 10)->nullable();
            $table->string('signos_talla', 10)->nullable();
            $table->text('exploracion_habitus')->nullable();
            $table->text('exploracion_cabeza')->nullable();
            $table->text('exploracion_cuello')->nullable();
            $table->text('exploracion_torax')->nullable();
            $table->text('exploracion_abdomen')->nullable();
            $table->text('exploracion_genitales')->nullable();
            $table->text('exploracion_extremidades')->nullable();
            $table->text('exploracion_piel')->nullable();
            $table->text('resultados_laboratorio')->nullable();
            $table->text('diagnosticos')->nullable();
            $table->text('tratamiento')->nullable();
            $table->text('pronostico')->nullable();
            $table->timestamps();

            $table->foreign('id_cita')->references('id')->on('citas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes_clinicos');
    }
};
