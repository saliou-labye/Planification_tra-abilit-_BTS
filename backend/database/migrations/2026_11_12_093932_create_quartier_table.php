<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quartier', function (Blueprint $table) {
            $table->increments('id_quart');
            $table->string('nom_quart', 100);
            $table->text('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quartier');
    }
};