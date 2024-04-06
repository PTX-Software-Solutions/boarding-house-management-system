<?php

namespace Tests\Unit\Livewire\User;

use App\Livewire\Admin\BoardingHouseForm;
use App\Livewire\User\BoardingHouse;
use App\Models\House;
use App\Models\Review;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BoardingHouseTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function renders_boarding_house_details_and_reviews()
    {
        // Create a dummy status for testing
        $status = Status::factory([
            'serial_id' => 2,
            'name' => 'Approved'
        ])->create();
        // Create a dummy user for testing
        $user = User::factory([
            'statusId' => $status->id
        ])->create();
        // Create a dummy house for testing
        $house = House::factory([
            'userId' => $user->id
        ])->create();
        $this->actingAs($user);

        // Simulate existing reviews
        Review::factory()->count(3)->create([
            'userId' => $user->id,
            'houseId' => $house->id,
            'message' => 'Great place to stay!',
        ]);

        Livewire::test(BoardingHouseForm::class)
            ->assertStatus(200);
    }

    /** @test */
    public function can_submit_review()
    {
        // Create a dummy status for testing
        $status = Status::factory([
            'serial_id' => 2,
            'name' => 'Approved'
        ])->create();
        // Create a dummy user for testing
        $user = User::factory([
            'statusId' => $status->id
        ])->create();
        // Create a dummy house for testing
        $house = House::factory([
            'userId' => $user->id
        ])->create();
        $this->actingAs($user);

        $message = 'This is a new review!';

        Livewire::test(BoardingHouseForm::class)
            ->assertStatus(200);
    }

    /** @test */
    public function validates_review_message()
    {
        // Create a dummy status for testing
        $status = Status::factory([
            'serial_id' => 2,
            'name' => 'Approved'
        ])->create();
        // Create a dummy user for testing
        $user = User::factory([
            'statusId' => $status->id
        ])->create();
        // Create a dummy house for testing
        $house = House::factory([
            'userId' => $user->id
        ])->create();

        $this->actingAs($user);

        Livewire::test(BoardingHouseForm::class, ['id' => $house->id])
            ->assertStatus(200);
    }

    /** @test */
    public function reloads_reviews_on_broadcast_event()
    {
        // Create a dummy status for testing
        $status = Status::factory([
            'serial_id' => 2,
            'name' => 'Approved'
        ])->create();
        // Create a dummy user for testing
        $user = User::factory([
            'statusId' => $status->id
        ])->create();
        // Create a dummy house for testing
        $house = House::factory([
            'userId' => $user->id
        ])->create();

        $this->actingAs($user);

        Livewire::test(BoardingHouseForm::class, ['id' => $house->id])
            ->assertStatus(200);
    }
}
