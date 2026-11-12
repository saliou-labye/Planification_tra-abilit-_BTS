<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client', function (Blueprint $table) {
            $table->increments('id_client');
            $table->unsignedInteger('id_utilisateur')->unique();
            $table->foreign('id_utilisateur')->references('id_utilisateur')->on('utilisateur')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client');
    }
};