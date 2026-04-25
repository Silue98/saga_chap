<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('betail', function (Blueprint $table) {
            $table->decimal('localisation_lat', 10, 7)->nullable()->after('disponibilite');
            $table->decimal('localisation_lng', 10, 7)->nullable()->after('localisation_lat');
            $table->timestamp('localisation_updated_at')->nullable()->after('localisation_lng');
            $table->string('localisation_adresse', 255)->nullable()->after('localisation_updated_at');
        });
    }

    public function down(): void
    {
        Schema::table('betail', function (Blueprint $table) {
            $table->dropColumn(['localisation_lat', 'localisation_lng', 'localisation_updated_at', 'localisation_adresse']);
        });
    }
};
