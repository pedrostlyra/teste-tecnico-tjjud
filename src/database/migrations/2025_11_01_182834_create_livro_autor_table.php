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
        Schema::create('livro_autor', function (Blueprint $table) {
            $table->foreignId('Livro_Codl')->constrained('livros', 'Codl')->onDelete('cascade');
            $table->foreignId('Autor_CodAu')->constrained('autores', 'CodAu')->onDelete('cascade');
            $table->primary(['Livro_Codl', 'Autor_CodAu']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livro_autor');
    }
};
