<?php

namespace Database\Seeders;

use App\Models\PaymentAgreementType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentAgreementTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name'             => '1 Month Deposit and 1 Month Advance',
            ],
        ];

        foreach ($datas as $data) {
            PaymentAgreementType::create([
                'name'  => $data['name']
            ]);
        }
    }
}
