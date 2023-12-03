<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name'             => 'Pending',
            ],
            [
                'name'             => 'Approved',
            ],
            [
                'name'             => 'Cancelled',
            ],
            [
                'name'             => 'Processing',
            ],
            [
                'name'             => 'Doing',
            ],
            [
                'name'             => 'For approval',
            ],
            [
                'name'             => 'Re-work',
            ],
            [
                'name'             => 'To-Released',
            ],
            [
                'name'             => 'Done',
            ],
            [
                'name'             => 'Yes',
            ],
            [
                'name'             => 'No',
            ],
            [
                'name'             => 'Paid',
            ],
            [
                'name'             => 'Unpaid',
            ],
            [
                'name'             => 'Active',
            ],
            [
                'name'             => 'Inactive',
            ],
            [
                'name'             => 'Inactive',
            ],
            [
                'name'             => 'Occupied',
            ],
        ];

        foreach ($datas as $data) {
            Status::create([
                'name'  => $data['name']
            ]);
        }
    }
}
