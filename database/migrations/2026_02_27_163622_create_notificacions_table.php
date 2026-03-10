<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                  ->constrained('empresas')
                  ->onDelete('cascade');
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->string('tipo');        // activo_mantenimiento, uso_prolongado, etc.
            $table->string('titulo');
            $table->text('mensaje');
            $table->string('icono')->default('🔔');
            $table->string('url')->nullable();
            $table->timestamp('leida_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'leida_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};