<?php

namespace App\Livewire\User;

use App\Enums\StatusEnums;
use App\Models\Reservation as ModelsReservation;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Reservation extends Component
{

    public function cancelReservation($id)
    {
        $this->dispatch('cancelRes', id: $id);
    }

    #[On('cancelReserv')]
    public function cancelReservFunc($id)
    {
        $status = Status::where('serial_id', StatusEnums::CANCELLED)->first();

        ModelsReservation::where('id', $id)->update([
            'statusId' => $status->id
        ]);
    }

    #[Layout('components.layouts.userAuth')]
    public function render()
    {
        $reservations = ModelsReservation::with('getUser', 'getHouse', 'getRoom', 'getStatus')
            ->whereHas('getStatus', function ($query) {
                $query->where('serial_id', StatusEnums::PENDING);
            })
            ->orderBy('created_at', 'DESC')
            ->where('userId', Auth::id())
            ->paginate(10);

        return view('livewire.user.reservation', [
            'reservations' => $reservations
        ]);
    }
}
