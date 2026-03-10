<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                  ->constrained('empresas')
                  ->onDelete('cascade');
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            $table->string('action', 20);        // create, update, delete
            $table->string('model', 100);        // App\Models\Activo
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('description')->nullable();
            $table->json('changes')->nullable();  // guarda before/after en updates
            $table->timestamps();

            $table->index(['empresa_id', 'created_at']);
            $table->index(['model', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};