<?php

namespace Database\Seeders;

use App\Models\RoomUtilityScope;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomUtilityScopeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name'             => 'Individual Usage',
            ],
            [
                'name'             => 'Fix Monthly Payment',
            ],
            [
                'name'             => 'Included Monthly Rent',
            ],
        ];

        foreach ($datas as $data) {
            RoomUtilityScope::create([
                'name'  => $data['name']
            ]);
        }
    }
}
