<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // L'employé évalué
            $table->string('period'); // ex: "Trimestre 1 2024"
            $table->text('objectifs')->nullable(); // Ce que l'employé doit atteindre
            $table->integer('note')->nullable(); // Note sur 5
            $table->text('commentaires')->nullable(); // Commentaire du RH
            $table->string('status')->default('en_attente'); // en_attente, terminee
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
};