<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Marketplace;

class MarketplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $amazonId = Marketplace::create(['name' => 'Amazon'])->id;
        $mercadoLivreId = Marketplace::create(['name' => 'Mercado Livre'])->id;
        
        $fees = [
            [$amazonId, 1, 0.2000],
            [$amazonId, 2, 0.1800],
            [$amazonId, 3, 0.1600],
            [$mercadoLivreId, 1, 0.1650],
            [$mercadoLivreId, 2, 0.1150],
            [$mercadoLivreId, 3, 0.1100],
        ];

        foreach ($fees as [$marketplaceId, $categoryId, $value]) {
            DB::table('marketplace_fee')->insert([
                'marketplace_id' => $marketplaceId,
                'category_id'    => $categoryId,
                'value'          => $value,
                'created_at'     => now(), // Good practice to include timestamps manually with DB::table
                'updated_at'     => now(),
            ]);
        }

    }
}
