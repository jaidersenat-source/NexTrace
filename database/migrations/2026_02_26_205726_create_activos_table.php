<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                  ->constrained('empresas')
                  ->onDelete('cascade');
            $table->string('nombre');
            $table->string('codigo')->nullable();
            $table->text('descripcion')->nullable();
            $table->decimal('valor', 12, 2)->default(0);
            $table->enum('estado', ['activo', 'mantenimiento', 'baja'])->default('activo');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activos');
    }
};