<?php

namespace Database\Seeders;

use App\Models\SocialMediaType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name'             => 'Facebook',
            ],
            [
                'name'             => 'Instagram',
            ],
            [
                'name'             => 'X',
            ]
        ];

        foreach ($datas as $data) {
            SocialMediaType::create([
                'name'  => $data['name']
            ]);
        }
    }
}
