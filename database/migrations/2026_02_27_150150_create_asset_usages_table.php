<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_usages', function (Blueprint $table) {
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
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();

            $table->index(['activo_id', 'ended_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_usages');
    }
};