<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('betail', function (Blueprint $table) {
            $table->id('id_betail');
            $table->string('type', 100);
            $table->string('race', 100);
            $table->integer('age');
            $table->decimal('poids', 5, 2);
            $table->decimal('prix', 10, 2);
            $table->string('origine', 150);
            $table->string('photo', 255)->nullable();
            $table->string('video', 255)->nullable();
            $table->boolean('disponibilite')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('betail');
       
    }
};
