<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                  ->constrained('empresas')
                  ->onDelete('cascade');
            $table->foreignId('activo_id')
                  ->constrained('activos')
                  ->onDelete('cascade');
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            $table->string('tipo');           // preventivo, correctivo, revision
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->timestamp('programado_at');
            $table->timestamp('completado_at')->nullable();
            $table->enum('estado', ['pendiente', 'en_proceso', 'completado', 'cancelado'])
                  ->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->decimal('costo', 12, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['empresa_id', 'estado']);
            $table->index(['activo_id', 'programado_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};