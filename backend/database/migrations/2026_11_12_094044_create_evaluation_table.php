<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation', function (Blueprint $table) {
            $table->smallIncrements('id_evalu');
            $table->dateTime('date_evalue')->useCurrent();
            $table->text('commentaire')->nullable();
            $table->unsignedTinyInteger('note_obte');
            $table->unsignedInteger('id_client');
            $table->unsignedInteger('id_collecteur');
            $table->foreign('id_client')->references('id_client')->on('client')->cascadeOnUpdate();
            $table->foreign('id_collecteur')->references('id_collecteur')->on('collecteur')->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation');
    }
};