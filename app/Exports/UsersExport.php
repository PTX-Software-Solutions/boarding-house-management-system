<?php

namespace App\Exports;

use App\Models\Reservation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{

    public function view(): View
    {
        $reservations = Reservation::with('getUser', 'getHouse', 'getRoom', 'getStatus')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('exports.reservations', [
            'reservations' => $reservations
        ]);
    }
}
