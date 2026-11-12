<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicule', function (Blueprint $table) {
            $table->increments('id_vehicu');
            $table->string('immatriculation', 20)->unique();
            $table->string('type_vehicule', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicule');
    }
};