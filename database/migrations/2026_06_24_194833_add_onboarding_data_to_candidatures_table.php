<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('candidatures', function (Blueprint $table) {
            // On utilise un type JSON pour stocker la checklist de façon flexible
            $table->json('onboarding_data')->nullable()->after('notes');
        });
    }

    public function down()
    {
        Schema::table('candidatures', function (Blueprint $table) {
            $table->dropColumn('onboarding_data');
        });
    }
};