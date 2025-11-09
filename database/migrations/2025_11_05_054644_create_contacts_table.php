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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre completo del contacto
            $table->string('email')->nullable(); // Email opcional
            $table->string('photo')->nullable(); // Ruta de la foto de perfil
            $table->text('address')->nullable(); // Dirección completa
            $table->text('notes')->nullable(); // Notas adicionales
            $table->boolean('is_favorite')->default(false); // Marcar como favorito
            
            // Relación con categorías
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            // Si se borra una categoría, el contacto no se borra, solo se pone category_id en null
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
