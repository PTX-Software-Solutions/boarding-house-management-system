<?php

namespace Tests\Unit\Livewire\User;

use App\Enums\StatusEnums;
use App\Livewire\User\RoomDetails;
use App\Models\House;
use App\Models\PaymentAgreementType;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Status;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomDetailsTest extends TestCase
{
    use RefreshDatabase;

    // /**
    //  * Tests rendering the component with a valid room.
    //  */
    // public function test_renders_room_details()
    // {
    //     // Create a dummy status for testing
    //     $status = Status::factory()->create();
    //     // Create a dummy user for testing
    //     $user = User::factory([
    //         'statusId' => $status->id
    //     ])->create();
    //     // Create a dummy house for testing
    //     $house = House::factory([
    //         'userId' => $user->id
    //     ])->create();
    //     $roomType = RoomType::factory()->create();
    //     $paymentAgreement = PaymentAgreementType::factory()->create();

    //     $room = Room::factory([
    //         'houseId' => $house->id,
    //         'roomTypeId' => $roomType->id,
    //         'paymentAgreementId' => $paymentAgreement->id,
    //         'statusId' => $status->id,
    //     ])->create();

    //     Livewire::test(RoomDetails::class, ['houseId' => $room->house_id, 'roomId' => $room->id])
    //         ->assertStatus(200);
    //     // ->assertViewHas('room', $room);
    //     // ->assertViewHas('reservations', []); // No reservations for a new room
    // }

    // /**
    //  * Tests validation for required fields.
    //  */
    // public function test_validates_required_fields()
    // {
    //     Livewire::test(RoomDetails::class)
    //         ->call('save')
    //         ->assertHasErrors(['checkIn']);
    // }

    // /**
    //  * Tests validation for check-in and check-out dates.
    //  */
    // public function test_validates_dates()
    // {
    //     $this->travelTo(now()->subDay()); // Set past date for check-in

    //     Livewire::test(RoomDetails::class)
    //         ->set('checkIn', now()->format('Y-m-d'))
    //         ->call('save')
    //         ->assertHasErrors(['checkIn']);

    //     $this->travelBack();

    //     Livewire::test(RoomDetails::class)
    //         ->set('checkIn', now()->format('Y-m-d'))
    //         ->set('checkOut', now()->subDay()->format('Y-m-d'))
    //         ->call('save')
    //         ->assertHasErrors(['checkOut']);
    // }

    // /**
    //  * Tests creating a reservation.
    //  */
    // public function test_creates_reservation()
    // {
    //     $room = Room::factory()->create();
    //     $user = User::factory()->create();

    //     Livewire::actingAs($user)
    //         ->test(RoomDetails::class, ['houseId' => $room->house_id, 'roomId' => $room->id])
    //         ->set('checkIn', now()->addDay()->format('Y-m-d'))
    //         ->call('save')
    //         ->assertRedirect('/reservations');

    //     $this->assertDatabaseHas('reservations', [
    //         'user_id' => $user->id,
    //         'house_id' => $room->house_id,
    //         'room_id' => $room->id,
    //         'status_id' => StatusEnums::PENDING,
    //         'check_in' => now()->addDay()->format('Y-m-d'),
    //     ]);
    // }
}
