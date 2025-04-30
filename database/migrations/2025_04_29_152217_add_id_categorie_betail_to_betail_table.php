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
        Schema::table('betail', function (Blueprint $table) {
            $table->unsignedBigInteger('id_categorie_betail')->after('id_betail'); // ou after('race') si tu veux
            $table->foreign('id_categorie_betail')->references('id_categorie')->on('categorie_betail')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('betail', function (Blueprint $table) {
            $table->dropForeign(['id_categorie_betail']);
            $table->dropColumn('id_categorie_betail');
        });
    }
};
