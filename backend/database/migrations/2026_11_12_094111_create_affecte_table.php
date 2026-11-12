<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affecte', function (Blueprint $table) {
            $table->unsignedInteger('id_quart');
            $table->unsignedInteger('id_collecteur');
            $table->date('date_');
            $table->primary(['id_quart', 'id_collecteur', 'date_']);
            $table->foreign('id_quart')->references('id_quart')->on('quartier')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('id_collecteur')->references('id_collecteur')->on('collecteur')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affecte');
    }
};