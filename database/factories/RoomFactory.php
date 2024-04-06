<?php

namespace Database\Factories;

use App\Models\House;
use App\Models\PaymentAgreementType;
use App\Models\RoomType;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'monthlyDeposit' => 2500,
            'houseId' => House::factory(),
            'roomTypeId' => RoomType::factory(),
            'paymentAgreementId' => PaymentAgreementType::factory(),
            'statusId' => Status::factory(),
        ];
    }
}
