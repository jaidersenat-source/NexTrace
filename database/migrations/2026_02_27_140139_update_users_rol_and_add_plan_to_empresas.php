<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Actualizar enum rol en users
        Schema::table('users', function (Blueprint $table) {
            $table->enum('rol', ['super_admin', 'admin', 'empleado'])
                  ->default('admin')
                  ->change();
        });

        // Agregar plan a empresas
        Schema::table('empresas', function (Blueprint $table) {
            $table->string('plan')->default('gratuito')->after('activo');
            $table->timestamp('plan_vence_at')->nullable()->after('plan');
            $table->text('notas_admin')->nullable()->after('plan_vence_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('rol', ['admin', 'empleado'])->default('admin')->change();
        });
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropColumn(['plan', 'plan_vence_at', 'notas_admin']);
        });
    }
};