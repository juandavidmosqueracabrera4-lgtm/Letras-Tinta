<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Clase de migración para crear la tabla de permisos
return new class extends Migration
{
    //Crea la tabla de permisos con los campos y restricciones correspondientes
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('description');
            $table->string('module');
            $table->timestamps();
        });
    }

    //Revierte la migracion eliminando la tabla de permisos
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
