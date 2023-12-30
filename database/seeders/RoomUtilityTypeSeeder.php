<?php

namespace Database\Seeders;

use App\Models\RoomUtilityType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomUtilityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name'             => 'Water',
            ],
            [
                'name'             => 'Electricity',
            ],
            [
                'name'             => 'Gas',
            ],
            [
                'name'             => 'Internet',
            ],
            [
                'name'             => 'Cable',
            ],
        ];

        foreach ($datas as $data) {
            RoomUtilityType::create([
                'name'  => $data['name']
            ]);
        }
    }
}
