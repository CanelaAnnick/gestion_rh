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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Titre de l'offre
            $table->string('department'); // Département ciblé
            $table->enum('type', ['CDI', 'CDD', 'Stage']); // Type de contrat
            $table->string('location')->default('Douala, Cameroun');
            $table->text('description')->nullable(); // Description du poste
            $table->string('requirements')->nullable(); // Compétences requises
            $table->enum('status', ['ouverte', 'fermée', 'pourvue'])->default('ouverte');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
