<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->foreignId('empresa_id')
          ->nullable()
          ->constrained('empresas')   // explícito
          ->onDelete('set null');
    $table->string('nombre');
    $table->string('apellido')->nullable(); // corregido
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->string('rol')->default('usuario');
    $table->boolean('activo')->default(true);
    $table->rememberToken();
    $table->softDeletes();             // agregado
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};