<?php

namespace App\Livewire\Management;

use App\Enums\StatusEnums;
use App\Models\House;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    #[Layout('components.layouts.managementAuth')]
    public function render()
    {

        $houses = House::where('userId', Auth::guard('management')->user()->id)->count();

        $rooms = Room::whereHas('getHouse', function ($query) {
            $query->where('userId', Auth::guard('management')->user()->id);
        })->count();

        $vacantRooms = Room::whereHas('getStatus', function ($query1) {
            $query1->where('serial_id', StatusEnums::VACANT);
        })->whereHas('getHouse', function ($query) {
            $query->where('userId', Auth::guard('management')->user()->id);
        })
            ->count();

        $occupiedRooms = Room::whereHas('getStatus', function ($query1) {
            $query1->where('serial_id', StatusEnums::OCCUPIED);
        })->whereHas('getHouse', function ($query) {
            $query->where('userId', Auth::guard('management')->user()->id);
        })
            ->count();

        return view('livewire.management.dashboard', [
            'houses'    => $houses,
            'rooms'     => $rooms,
            'vacantRooms' => $vacantRooms,
            'occupiedRooms' => $occupiedRooms
        ]);
    }
}
