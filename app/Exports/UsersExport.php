<?php

namespace App\Exports;

use App\Models\Reservation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{

    public $search;

    public function __construct($search)
    {
        $this->search = $search;
    }

    public function view(): View
    {
        $reservations = Reservation::with('getUser', 'getHouse', 'getRoom', 'getStatus')
            ->orderBy('created_at', 'DESC')
            ->when($this->search, function ($query) {
                $query->whereHas('getUser', function ($query1) {
                    $query1->where('firstName', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('lastName', 'LIKE', '%' . $this->search . '%');
                })
                    ->orWhereHas('getHouse', function ($query2) {
                        $query2->where('houseName', 'LIKE', '%' . $this->search . '%');
                    });
            })
            ->get();

        return view('exports.reservations', [
            'reservations' => $reservations
        ]);
    }
}
