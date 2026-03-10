<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categoria_activos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                  ->nullable() // null = categoría global del sistema
                  ->constrained('empresas')
                  ->onDelete('cascade');
            $table->string('nombre');
            $table->string('icono')->default('📦');
            $table->json('campos'); // define qué atributos tiene esta categoría
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categoria_activos');
    }
};