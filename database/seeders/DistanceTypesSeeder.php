<?php

namespace Database\Seeders;

use App\Models\DistanceTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistanceTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'Meter(s)',
            ],
            [
                'name' => 'Kilometer(s)',
            ],
            [
                'name' => 'Yard(s)',
            ],
        ];


        foreach ($datas as $data) {
            DistanceTypes::create([
                'name' => $data['name']
            ]);
        }
    }
}
