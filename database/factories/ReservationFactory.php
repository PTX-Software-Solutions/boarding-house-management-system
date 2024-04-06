<?php

namespace Database\Factories;

use App\Models\House;
use App\Models\PaymentAgreementType;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'userId' => User::factory(),
            'houseId' => House::factory(),
            'roomId' => Room::factory(),
            'statusId' => Status::factory(),
            'checkIn' => Carbon::now(),
        ];
    }
}
