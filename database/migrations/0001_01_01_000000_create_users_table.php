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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // --- CHAMPS AJOUTÉS POUR NOTRE APP RH ---
            $table->enum('role', ['admin', 'employee'])->default('employee');
            $table->string('poste')->nullable(); // ex: Directrice RH
            $table->string('departement')->nullable();
            $table->integer('salaire')->default(0); // Salaire en FCFA (ex: 150000 pour 150.000)
            $table->string('avatar')->nullable();
            // ------------------------------------------
    
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
