<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'Single Room'
            ],
            [
                'name' => 'Double Room'
            ],
            [
                'name' => 'Dormitory Room'
            ],
            [
                'name' => 'Ensuite Room'
            ],
            [
                'name' => 'Studio Apartment'
            ],
            [
                'name' => 'Shared Bathroom'
            ],
            [
                'name' => 'Family Room'
            ],
        ];

        foreach ($datas as $data) {
            RoomType::create([
                'name' => $data['name']
            ]);
        }
    }
}
