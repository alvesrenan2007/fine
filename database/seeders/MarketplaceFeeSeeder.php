<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarketplaceFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fees = [
            [
                'marketplace_id' => 1,
                'category_id'    => 1,
                'value'          => 0.1100,
            ],
            [
                'marketplace_id' => 1,
                'category_id'    => 2,
                'value'          => 0.1600,
            ],
            [
                'marketplace_id' => 1,
                'category_id'    => 3,
                'value'          => 0.1650,
            ],
            [
                'marketplace_id' => 1,
                'category_id'    => 4,
                'value'          => 0.1650,
            ],
            [
                'marketplace_id' => 1,
                'category_id'    => 5,
                'value'          => 0.1800,
            ],
            [
                'marketplace_id' => 1,
                'category_id'    => 6,
                'value'          => 0.1800,
            ],
            [
                'marketplace_id' => 1,
                'category_id'    => 7,
                'value'          => 0.1150,
            ],
            [
                'marketplace_id' => 1,
                'category_id'    => 8,
                'value'          => 0.1100,
            ],
            [
                'marketplace_id' => 1,
                'category_id'    => 9,
                'value'          => 0.1600,
            ],
            [
                'marketplace_id' => 1,
                'category_id'    => 10,
                'value'          => 0.1600,
            ],
            [
                'marketplace_id' => 2,
                'category_id'    => 1,
                'value'          => 0.1200,
            ],
            [
                'marketplace_id' => 2,
                'category_id'    => 2,
                'value'          => 0.1500,
            ],
            [
                'marketplace_id' => 2,
                'category_id'    => 3,
                'value'          => 0.1600,
            ],
            [
                'marketplace_id' => 2,
                'category_id'    => 4,
                'value'          => 0.1600,
            ],
            [
                'marketplace_id' => 2,
                'category_id'    => 5,
                'value'          => 0.0800,
            ],
            [
                'marketplace_id' => 2,
                'category_id'    => 6,
                'value'          => 0.0800,
            ],
            [
                'marketplace_id' => 2,
                'category_id'    => 7,
                'value'          => 0.0800,
            ],
            [
                'marketplace_id' => 2,
                'category_id'    => 8,
                'value'          => 0.0800,
            ],
            [
                'marketplace_id' => 2,
                'category_id'    => 9,
                'value'          => 0.1500,
            ],
            [
                'marketplace_id' => 2,
                'category_id'    => 10,
                'value'          => 0.1500,
            ],
        ];

        foreach ($fees as $fee) {
            DB::table('marketplace_fee')->updateOrCreate(
                [
                    // Unique combination that identifies the record
                    'marketplace_id' => $fee['marketplace_id'],
                    'category_id'    => $fee['category_id'],
                ],
                [
                    'value' => $fee['value'],
                    // timestamps are automatically managed by Laravel
                ]
            );
        }       //
    }
}
