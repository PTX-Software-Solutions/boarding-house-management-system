<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserTypeSeeder::class,
            DistanceTypesSeeder::class,
            StatusSeeder::class,
            RoomTypesSeeder::class,
            AmenitiesSeeder::class,
            SocialMediaSeeder::class,
            PaymentAgreementTypesSeeder::class,
            RoomUtilityScopeSeeder::class,
            RoomUtilityTypeSeeder::class,
            PaymentTypesSeeder::class,
            UserRoleSeeder::class,
        ]);
    }

    
}
