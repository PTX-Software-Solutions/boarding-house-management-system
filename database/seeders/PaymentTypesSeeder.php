<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name'             => 'Gcash',
            ],
            [
                'name'             => 'Cash',
            ],
            [
                'name'             => 'Gcash/Cash',
            ],
        ];

        foreach ($datas as $data) {
            PaymentType::create([
                'name'  => $data['name']
            ]);
        }
    }
}
