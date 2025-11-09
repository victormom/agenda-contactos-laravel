<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('phone_numbers', function (Blueprint $table) {
            $table->id();
            
            // Relación con contactos
            $table->foreignId('contact_id')->constrained()->onDelete('cascade');
            // Si borramos un contacto, sus teléfonos también se borran automáticamente
            
            $table->string('type')->default('mobile'); // Tipo: mobile, home, work
            $table->string('number'); // Número telefónico
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phone_numbers');
    }
};
