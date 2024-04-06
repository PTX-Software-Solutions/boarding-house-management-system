<?php

namespace Tests\Unit\Livewire\User;

use App\Enums\StatusEnums;
use App\Livewire\User\Transaction;
use App\Models\House;
use App\Models\PaymentAgreementType;
use App\Models\Rating;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests rendering the component with reservations.
     */
    public function test_renders_transactions()
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
            ->test(Transaction::class)
            ->assertStatus(200);
    }

    /**
     * Tests filtering reservations by allowed statuses.
     */
    public function test_filters_transactions_by_status()
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
            ->test(Transaction::class)
            ->assertStatus(200);
    }

    /**
     * Tests toggling the rating form for a reservation.
     */
    public function test_toggles_rating_form()
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
        ])->create();

        Livewire::actingAs($user)
            ->test(Transaction::class)
            ->call('toggleReservation', $reservation->id)
            ->assertSet('isRatingClicked', true)
            ->assertSet('selectedToggleReservation', $reservation->id)
            ->assertStatus(200);
    }

    /**
     * Tests rating a reservation.
     */
    public function test_rates_transactions()
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
        ])->create();


        $data = [
            'rate' => 4,
            'reservationId' => $reservation->id,
            'houseId' => $reservation->getHouse->id,
        ];

        Livewire::actingAs($user)
            ->test(Transaction::class)
            ->call('toggleReservation', $reservation->id)
            ->call('rateReservation', $data)
            ->assertRedirect('/transaction')
            ->assertStatus(200);
    }
}
