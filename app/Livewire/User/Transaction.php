<?php

namespace App\Livewire\User;

use App\Enums\StatusEnums;
use App\Models\Rating;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Transaction extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $isRatingClicked = false;
    public $selectedToggleReservation;
    public $rating = 0;


    public function rateReservation($data)
    {
        Rating::create([
            'userId' => Auth::id(),
            'houseId' => $data['houseId'],
            'reservationId' => $data['reservationId'],
            'rating'    => $data['rate']
        ]);

        return $this->redirect('/transaction', navigate: true);
    }

    public function toggleReservation($id)
    {
        $this->selectedToggleReservation = $id;
        $this->isRatingClicked = true;
    }

    #[Layout('components.layouts.userAuth')]
    public function render()
    {
        $reservations = Reservation::withTrashed()
            ->with('getUser', 'getHouse', 'getRoom', 'getStatus', 'getRating')
            ->whereHas('getStatus', function ($query) {
                $query->whereIn('serial_id', [StatusEnums::CANCELLED, StatusEnums::APPROVED]);
            })
            ->orderBy('created_at', 'DESC')
            ->where('userId', Auth::id())
            ->paginate(10);

            // dd($reservations);

        return view('livewire.user.transaction', [
            'reservations' => $reservations
        ]);
    }
}
