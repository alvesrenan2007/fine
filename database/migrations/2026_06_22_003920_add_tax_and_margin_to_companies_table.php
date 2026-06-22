<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//use Illuminate\Support\\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Setting up new columns
        Schema::table('companies', function (Blueprint $table) {
            $table->decimal('tax_fee', 5, 4)->default(0.1);
            $table->decimal('profit_margin', 5, 4)->default(0.1);
        });

        // Seeding new columns
        DB::table('companies')->where('id', 1)->update(['tax_fee' => 0.07, 'profit_margin' => 0.1]);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('tax_fee');
            $table->dropColumn('profit_margin');
        });
    }
};
