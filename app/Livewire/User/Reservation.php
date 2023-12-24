<?php

namespace App\Livewire\User;

use App\Enums\StatusEnums;
use App\Models\Reservation as ModelsReservation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Reservation extends Component
{
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
