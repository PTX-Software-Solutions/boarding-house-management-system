<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'Student',
            ],
            [
                'name' => 'Worker',
            ],
        ];


        foreach ($datas as $data) {
            UserRole::create([
                'name' => $data['name']
            ]);
        }
    }
}
