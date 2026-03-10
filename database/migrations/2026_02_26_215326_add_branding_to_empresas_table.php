<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->string('logo_url')->nullable()->after('slug');
            $table->string('color_primario', 7)->default('#4f46e5')->after('logo_url');
            $table->string('color_secundario', 7)->default('#818cf8')->after('color_primario');
            $table->string('color_sidebar', 7)->default('#1e1b4b')->after('color_secundario');
        });
    }

    public function down(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropColumn(['logo_url', 'color_primario', 'color_secundario', 'color_sidebar']);
        });
    }
};