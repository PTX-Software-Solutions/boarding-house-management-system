<?php

namespace App\Livewire\Admin;

use App\Enums\StatusEnums;
use App\Models\Reservation;
use App\Models\Status;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Confirmation extends Component
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
        $status = Status::where('serial_id', StatusEnums::APPROVED)->first();

        Reservation::where('id', $id)->update([
            'statusId' => $status->id
        ]);
    }

    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        $reservations = Reservation::with('getUser', 'getHouse', 'getRoom', 'getStatus')
            ->whereHas('getStatus', function ($query) {
                $query->where('serial_id', StatusEnums::FOR_APPROVAL);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('livewire.admin.confirmation', [
            'reservations' => $reservations
        ]);
    }
}
