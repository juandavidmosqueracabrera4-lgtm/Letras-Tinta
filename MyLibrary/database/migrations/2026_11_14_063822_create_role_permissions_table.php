<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Crear la tabla intermedia que relaciona roles con permisos
        Schema::create('role_permissions', function (Blueprint $table) {

            //La llave foranea que referencia al rol
            $table->foreignId('role_id')
                ->constrained('roles')
                ->cascadeOnDelete();

            //La llave foranea que referencia al permiso
            $table->foreignId('permission_id')
                ->constrained('permissions')
                ->cascadeOnDelete();

            // Define la pk para que no se repitan los permisos para un mismo rol
            $table->primary(['role_id', 'permission_id']);
        });
    }

    public function down(): void
    {
        // Eliminar la tabla intermedia cuando se revierte la migración
        Schema::dropIfExists('role_permissions');
    }
};
