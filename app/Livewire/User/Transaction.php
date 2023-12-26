<?php

namespace App\Livewire\User;

use App\Enums\StatusEnums;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Transaction extends Component
{
    public $isRatingClicked = false;
    public $selectedToggleReservation;
    public $rating = 0;

    
    public function rateReservation($data)
    {
        dd($data);
    }

    public function toggleReservation($id)
    {
        $this->selectedToggleReservation = $id;
        $this->isRatingClicked = true;
    }

    #[Layout('components.layouts.userAuth')]
    public function render()
    {
        $reservations = Reservation::with('getUser', 'getHouse', 'getRoom', 'getStatus')
            ->whereHas('getStatus', function ($query) {
                $query->whereIn('serial_id', [StatusEnums::CANCELLED, StatusEnums::APPROVED]);
            })
            ->orderBy('created_at', 'DESC')
            ->where('userId', Auth::id())
            ->paginate(10);

        return view('livewire.user.transaction', [
            'reservations' => $reservations
        ]);
    }
}
