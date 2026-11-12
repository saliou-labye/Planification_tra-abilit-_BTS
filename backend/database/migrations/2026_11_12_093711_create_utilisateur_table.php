<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('utilisateur', function (Blueprint $table) {
            $table->increments('id_utilisateur');
            $table->string('nom_utilisateur', 50);
            $table->string('prenom_utilisateur', 50);
            $table->string('tel', 15);
            $table->string('email', 100)->unique();
            $table->string('mot_de_passe', 255);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('utilisateur');
    }
};