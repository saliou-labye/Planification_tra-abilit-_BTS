<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payement', function (Blueprint $table) {
            $table->increments('id_paiy');
            $table->decimal('montant', 10, 2);
            $table->string('mois_concerne', 30);
            $table->dateTime('date_pay')->useCurrent();
            $table->string('statut_pay', 20)->default('En attente');
            $table->unsignedInteger('id_client');
            $table->foreign('id_client')->references('id_client')->on('client')->cascadeOnUpdate();
            $table->unique(['id_client', 'mois_concerne']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payement');
    }
};