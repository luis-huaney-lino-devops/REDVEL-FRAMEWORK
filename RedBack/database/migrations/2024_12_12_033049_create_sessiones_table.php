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
        Schema::create('sessiones', function (Blueprint $table) {
            $table->bigIncrements('id_sesiones');
            $table->string('ip_address', 45);
            $table->date('fecha_hora_secion');
            $table->unsignedBigInteger('fk_idusuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessiones');
    }
};
