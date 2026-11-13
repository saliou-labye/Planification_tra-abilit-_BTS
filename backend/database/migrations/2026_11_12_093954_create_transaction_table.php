<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->smallIncrements('id_transac');
            $table->double('quantite_achetee');
            $table->decimal('montant_payer', 10, 2);
            $table->dateTime('date_traitement')->useCurrent();
            $table->unsignedInteger('id_servicet');
            $table->unsignedInteger('id_partenaire');
            $table->foreign('id_servicet')->references('id_servicet')->on('service_trie')->cascadeOnUpdate();
            $table->foreign('id_partenaire')->references('id_partenaire')->on('partenaire')->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};