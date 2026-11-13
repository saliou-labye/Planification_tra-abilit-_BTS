<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dechet_trie', function (Blueprint $table) {
            $table->smallIncrements('id_dechet');
            $table->string('type_dechet', 50);
            $table->double('poid_estime');
            $table->string('statut_vente', 30)->default('Déclaré');
            $table->double('poids_reel')->nullable();
            $table->string('destination', 50)->nullable();
            $table->unsignedSmallInteger('id_transac')->nullable();
            $table->unsignedInteger('id_client');
            $table->unsignedInteger('id_servicet')->nullable();
            $table->foreign('id_transac')->references('id_transac')->on('transaction')->cascadeOnUpdate();
            $table->foreign('id_client')->references('id_client')->on('client')->cascadeOnUpdate();
            $table->foreign('id_servicet')->references('id_servicet')->on('service_trie')->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dechet_trie');
    }
};