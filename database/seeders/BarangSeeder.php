<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            [
                'kode' => 'BR101',
                'nama' => 'Asrock B650M-H',
                'harga' => 2_000_000,
            ],
            [
                'kode' => 'BR102',
                'nama' => 'AMD Ryzen 5 7600x',
                'harga' => 3_200_000,
            ],
            [
                'kode' => 'BR103',
                'nama' => 'Adata XPG Lancer 16GB Dual Channel',
                'harga' => 1_199_000,
            ],
        ];

        foreach ($seeds as $seed) {
            Barang::create($seed);
        }
    }
}
