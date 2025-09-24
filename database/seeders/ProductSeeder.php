<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Masukkan beberapa data produk
        DB::table('products')->insert([
            [
                'name' => 'Kemeja Flanel',
                'price' => 150000,
                'description' => 'Kemeja flanel kotak-kotak bahan katun premium.',
                'stock' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Celana Chino',
                'price' => 250000,
                'description' => 'Celana chino slim-fit warna krem.',
                'stock' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}