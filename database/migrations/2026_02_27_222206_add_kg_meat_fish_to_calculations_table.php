<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('calculations', function (Blueprint $table) {
            
            $table->decimal('alimentation_kg_viande', 8, 2)->default(0)->after('alimentation_regime');
            $table->decimal('alimentation_kg_poisson', 8, 2)->default(0)->after('alimentation_kg_viande');
        });
    }

    
    public function down(): void
    {
        Schema::table('calculations', function (Blueprint $table) {
            $table->dropColumn(['alimentation_kg_viande', 'alimentation_kg_poisson']);
        });
    }
};