<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('signalement_voie', function (Blueprint $table) {
            $table->increments('id_signal');
            $table->double('longitude');
            $table->double('latitude');
            $table->text('type_anomalie');
            $table->string('statut_signal', 40)->default('Signalé');
            $table->unsignedInteger('id_controlleur')->nullable();
            $table->unsignedInteger('id_client');
            $table->foreign('id_controlleur')->references('id_controlleur')->on('controlleur')->cascadeOnUpdate();
            $table->foreign('id_client')->references('id_client')->on('client')->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signalement_voie');
    }
};