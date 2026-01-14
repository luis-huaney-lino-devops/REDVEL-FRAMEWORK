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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->integer('idusuarios', true);
            $table->text('codigo_usuario');
            $table->timestamp('email_verificado')->nullable();
            $table->tinyInteger('estado');
            $table->string('nomusu');
            $table->text('password');
            $table->enum('tipo_autenticacion', ['local', 'google', 'facebook']);
            $table->string('provider_id')->nullable();
            $table->string('provider_token')->nullable();
            $table->timestamp('fecha_creacion')->nullable();
            $table->dateTime('fecha_ultimo_acceso');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('fk_idpersonas')->index('fk_personas2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
