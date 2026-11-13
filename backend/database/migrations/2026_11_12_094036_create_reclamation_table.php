<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reclamation', function (Blueprint $table) {
            $table->bigIncrements('id_reclam');
            $table->text('description');
            $table->dateTime('date_soumi')->useCurrent();
            $table->string('statut', 30)->default('Ouverte');
            $table->unsignedInteger('id_collect')->nullable();
            $table->unsignedInteger('id_client');
            $table->foreign('id_collect')->references('id_collect')->on('collecte')->cascadeOnUpdate();
            $table->foreign('id_client')->references('id_client')->on('client')->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reclamation');
    }
};