<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            [
                'kode' => 'CS231',
                'nama' => 'Agus',
                'telp' => '082123456789',
            ],
            [
                'kode' => 'CS50',
                'nama' => 'Budi',
                'telp' => '081222333444',
            ]
        ];

        foreach ($seeds as $seed) {
            Customer::create($seed);
        }
    }
}
