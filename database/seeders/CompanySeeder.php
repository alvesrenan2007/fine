<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sample = [
            'name' => 'Ipsum Lorem Inc',
            'cnpj' => '12345678/0001-90',
            'imposto' => '0.075'
        ];

        DB::table('companies')->insert([
            'name' => $sample['name'],
            'cnpj' => $sample['cnpj'],
            'imposto' => $sample['imposto']
        ]);
    }
}
