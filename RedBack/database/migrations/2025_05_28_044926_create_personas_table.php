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
        Schema::create('personas', function (Blueprint $table) {
            $table->integer('idpersonas', true);
            $table->string('dni', 8);
            $table->text('fotografia')->nullable();
            $table->date('fecha_nacimiento');
            $table->string('primer_apell', 45);
            $table->string('segundo_apell', 45);
            $table->string('nombres', 45);
            $table->string('correo', 100)->nullable();
            $table->string('telefono', 15)->nullable();
            $table->text('direccion')->nullable();
            $table->integer('fk_idgeneros')->index('fk_generos1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
