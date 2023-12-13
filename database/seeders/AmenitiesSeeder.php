<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use function Psy\debug;

class AmenitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'Bed(s) with mattress and bedding',
            ],
            [
                'name' => 'Closet',
            ],
            [
                'name' => 'Drawers'
            ],
            [
                'name' => 'Desk and chair'
            ],
            [
                'name' => 'Air condition'
            ],
            [
                'name' => 'Wifi access'
            ],
            [
                'name' => 'Private bathroom'
            ],
            [
                'name' => 'Shared bathroom'
            ],
            [
                'name' => 'Private kitchen'
            ],
            [
                'name' => 'Shared kitchen'
            ],
            [
                'name' => 'Surveillance CCTV'
            ],
            [
                'name' => 'Appliances'
            ],
            [
                'name' => 'Parking Space'
            ],
            [
                'name' => 'Gym/fitness facilities'
            ]
        ];


        foreach ($datas as $data) {
            Amenity::create([
                'name' => $data['name']
            ]);
        }
    }
}
