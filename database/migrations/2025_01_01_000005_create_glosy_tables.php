<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabla de Dueñas/Salones
        if (!Schema::hasTable('salons')) {
            Schema::create('salons', function (Blueprint $table) {
                $table->id();
                $table->string('nombre_negocio'); // Nails Lety
                $table->string('slug')->unique(); // nailslety
                $table->string('color_brand')->default('#AB3E86');
                $table->boolean('activo')->default(true);
                $table->timestamps();
            });
        }

        // 2. Tabla de Servicios
        if (!Schema::hasTable('servicios')) {
            Schema::create('servicios', function (Blueprint $table) {
                $table->id();
                $table->foreignId('salon_id')->constrained('salons')->onDelete('cascade');
                $table->string('nombre'); // Gelish
                $table->decimal('precio', 8, 2);
                $table->integer('duracion_minutos');
                $table->timestamps();
            });
        }

        // 3. Tabla de Citas
        if (!Schema::hasTable('citas')) {
            Schema::create('citas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('salon_id')->constrained('salons')->onDelete('cascade');
                $table->foreignId('servicio_id')->constrained('servicios');
                $table->string('cliente_nombre');
                $table->string('cliente_telefono');
                $table->dateTime('fecha_hora_inicio');
                $table->enum('estado', ['pendiente', 'confirmada', 'cancelada'])->default('pendiente');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
        Schema::dropIfExists('servicios');
        Schema::dropIfExists('salons');
    }
};