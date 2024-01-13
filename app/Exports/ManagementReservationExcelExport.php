<?php

namespace App\Exports;

use App\Models\Reservation;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class ManagementReservationExcelExport implements FromView
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
            ->whereHas('getHouse', function ($query3) {
                $query3->where('userId', Auth::guard('management')->user()->id);
            })
            ->when($this->search, function ($query) {
                $query->whereHas('getUser', function ($query1) {
                    $query1->where('firstName', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('lastName', 'LIKE', '%' . $this->search . '%');
                })
                    ->orWhereHas('getHouse', function ($query2) {
                        $query2->where('userId', Auth::guard('management')->user()->id)
                            ->where('houseName', 'LIKE', '%' . $this->search . '%');
                    });
            })
            ->get();

        return view('exports.reservations', [
            'reservations' => $reservations
        ]);
    }
}
