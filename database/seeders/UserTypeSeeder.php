<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use function Psy\debug;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'CLIENT',
            ],
            [
                'name' => 'ADMIN',
            ],
            [
                'name' => 'MANAGEMENT'
            ]
        ];


        foreach ($datas as $data) {
            UserType::create([
                'name' => $data['name']
            ]);
        }
    }
}
