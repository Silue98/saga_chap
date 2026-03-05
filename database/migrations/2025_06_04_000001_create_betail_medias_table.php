<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('betail_medias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_betail');
            $table->enum('type', ['image', 'video']);
            $table->string('chemin', 191);
            $table->boolean('principale')->default(false); // image principale affichée sur la carte
            $table->integer('ordre')->default(0);
            $table->timestamps();

            $table->foreign('id_betail')
                  ->references('id_betail')
                  ->on('betail')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('betail_medias');
    }
};
