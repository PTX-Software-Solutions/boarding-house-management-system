<?php

namespace App\Livewire\Management;

use App\Enums\StatusEnums;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class ManagementConfirmation extends Component
{

    public function cancelReservation(string $id)
    {
        $this->dispatch('cancelRes', id: $id);
    }

    #[On('cancelReserv')]
    public function cancelReservFunc($id)
    {
        $status = Status::where('serial_id', StatusEnums::CANCELLED)->first();

        Reservation::where('id', $id)->update([
            'statusId' => $status->id
        ]);
    }

    public function approveReservation(string $id)
    {
        $this->dispatch('approveRes', id: $id);
    }

    #[On('approveReserv')]
    public function approveReservFunc($id)
    {
        $statusApproved = Status::where('serial_id', StatusEnums::APPROVED)->first();
        $statusOccupied = Status::where('serial_id', StatusEnums::OCCUPIED)->first();

        Reservation::where('id', $id)->update([
            'statusId' => $statusApproved->id
        ]);

        // Update the room status
        $reservation = Reservation::where('id', $id)->first();
        $room = Room::findOrFail($reservation->roomId);

        $room->update([
            'statusId' => $statusOccupied->id
        ]);
    }

    #[Layout('components.layouts.managementAuth')]
    public function render()
    {
        $reservations = Reservation::with('getUser', 'getHouse', 'getRoom', 'getStatus')
            ->whereHas('getStatus', function ($query) {
                $query->where('serial_id', StatusEnums::FOR_APPROVAL);
            })
            ->whereHas('getHouse', function ($query3) {
                $query3->where('userId', Auth::guard('management')->user()->id);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('livewire.management.management-confirmation', [
            'reservations' => $reservations
        ]);
    }
}
