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
            $table->json('padecimientos_adicionales')->nullable()->after('padecimiento_actual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expedientes_clinicos', function (Blueprint $table) {
            $table->dropColumn('padecimientos_adicionales');
        });
    }
};
