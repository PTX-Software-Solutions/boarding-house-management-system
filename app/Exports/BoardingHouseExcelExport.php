<?php

namespace App\Exports;

use App\Enums\StatusEnums;
use App\Models\House;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BoardingHouseExcelExport implements FromView
{
    public function view(): View
    {
        $boardingHouses = House::withCount([
            'getRooms as vacant_rooms' => function ($query1) {
                $query1->whereHas('getStatus', function ($query2) {
                    $query2->where('serial_id', StatusEnums::VACANT);
                });
            },
            'getRooms as occupied_rooms' => function ($query1) {
                $query1->whereHas('getStatus', function ($query2) {
                    $query2->where('serial_id', StatusEnums::OCCUPIED);
                });
            }
        ])
            ->latest()
            ->get();

        return view('exports.boarding-house', [
            'boardingHouses' => $boardingHouses
        ]);
    }
}
