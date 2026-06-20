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
        Schema::create('marketplace_fee', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('marketplace_id')->constrained('marketplaces')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->decimal('value', 5, 4);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marketplace_fee', function (Blueprint $table) {
            $table->dropForeign(['marketplace_id']); 
            $table->dropForeign(['category_id']); 
        });

        Schema::dropIfExists('marketplace_fee');
    }
};
