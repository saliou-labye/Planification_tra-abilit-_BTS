<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reside', function (Blueprint $table) {
            $table->unsignedInteger('id_quart');
            $table->unsignedInteger('id_client');
            $table->primary(['id_quart', 'id_client']);
            $table->foreign('id_quart')->references('id_quart')->on('quartier')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('id_client')->references('id_client')->on('client')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reside');
    }
};