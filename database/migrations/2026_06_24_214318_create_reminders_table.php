<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date_event');
            $table->enum('type', ['anniversaire', 'contrat', 'evenement'])->default('evenement');
            $table->boolean('is_read')->default(false); // true quand l'événement est passé/géré
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reminders');
    }
};