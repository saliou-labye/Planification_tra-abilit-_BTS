<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collecte', function (Blueprint $table) {
            $table->increments('id_collect');
            $table->date('date_prevue');
            $table->date('date_effect')->nullable();
            $table->string('statut_collec', 30)->default('Planifiée');
            $table->unsignedInteger('id_servicet');
            $table->unsignedInteger('id_collecteur');
            $table->unsignedInteger('id_vehicu');
            $table->unsignedInteger('id_quart');
            $table->foreign('id_servicet')->references('id_servicet')->on('service_trie')->cascadeOnUpdate();
            $table->foreign('id_collecteur')->references('id_collecteur')->on('collecteur')->cascadeOnUpdate();
            $table->foreign('id_vehicu')->references('id_vehicu')->on('vehicule')->cascadeOnUpdate();
            $table->foreign('id_quart')->references('id_quart')->on('quartier')->cascadeOnUpdate();
            $table->unique(['id_collecteur', 'date_prevue']);
            $table->unique(['id_vehicu', 'date_prevue']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collecte');
    }
};