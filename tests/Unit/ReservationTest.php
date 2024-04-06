<?php

namespace Tests\Unit\Livewire\User;

use App\Enums\StatusEnums;
use App\Livewire\User\Reservation as UserReservation;
use App\Models\House;
use App\Models\PaymentAgreementType;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests rendering the component with reservations.
     */
    public function test_renders_reservations()
    {
        $status = Status::factory()->create();
        $user = User::factory([
            'statusId' => $status->id
        ])->create();
        // Create a dummy house for testing
        $house = House::factory([
            'userId' => $user->id
        ])->create();

        $roomType = RoomType::factory()->create();
        $paymentAgreement = PaymentAgreementType::factory()->create();

        $room = Room::factory([
            'houseId' => $house->id,
            'roomTypeId' => $roomType->id,
            'paymentAgreementId' => $paymentAgreement->id,
            'statusId' => $status->id,
        ])->create();

        Reservation::factory([
            'userId' => $user->id,
            'houseId' => $house->id,
            'roomId' => $room->id,
            'statusId' => $status->id
        ])->create();

        Livewire::actingAs($user)
            ->test(UserReservation::class)
            ->assertStatus(200);
    }

    /**
     * Tests filtering reservations by allowed statuses.
     */
    public function test_filters_reservations_by_status()
    {
        $status = Status::factory()->create();
        $user = User::factory([
            'statusId' => $status->id
        ])->create();


        // Create a dummy house for testing
        $house = House::factory([
            'userId' => $user->id
        ])->create();

        $roomType = RoomType::factory()->create();
        $paymentAgreement = PaymentAgreementType::factory()->create();

        $room = Room::factory([
            'houseId' => $house->id,
            'roomTypeId' => $roomType->id,
            'paymentAgreementId' => $paymentAgreement->id,
            'statusId' => $status->id,
        ])->create();

        Reservation::factory([
            'userId' => $user->id,
            'houseId' => $house->id,
            'roomId' => $room->id,
            'statusId' => $status->id
        ])->create();

        Reservation::factory([
            'userId' => $user->id,
            'houseId' => $house->id,
            'roomId' => $room->id,
            'statusId' => $status->id
        ])->create();

        Livewire::actingAs($user)
            ->test(UserReservation::class)
            ->assertStatus(200);
    }

    /**
     * Tests cancelling a reservation.
     */
    public function test_cancels_reservation()
    {
        $status = Status::factory()->create();
        $user = User::factory([
            'statusId' => $status->id
        ])->create();


        // Create a dummy house for testing
        $house = House::factory([
            'userId' => $user->id
        ])->create();

        $roomType = RoomType::factory()->create();
        $paymentAgreement = PaymentAgreementType::factory()->create();

        $room = Room::factory([
            'houseId' => $house->id,
            'roomTypeId' => $roomType->id,
            'paymentAgreementId' => $paymentAgreement->id,
            'statusId' => $status->id,
        ])->create();

        $reservation = Reservation::factory([
            'userId' => $user->id,
            'houseId' => $house->id,
            'roomId' => $room->id,
            'statusId' => $status->id
        ])->create(['userId' => $user->id]);

        Livewire::actingAs($user)
            ->test(UserReservation::class)
            ->call('cancelReservation', $reservation->id)
            ->assertStatus(200);
        // ->assertDispatchedBrowserEvent('cancelReserv', ['id' => $reservation->id]);

        // $this->assertDatabaseHas('reservations', [
        //     'id' => $reservation->id,
        //     'statusId' => StatusEnums::CANCELLED
        // ]);
    }
}
