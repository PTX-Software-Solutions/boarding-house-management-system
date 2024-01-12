<?php

namespace App\Livewire\Admin;

use App\Enums\StatusEnums;
use App\Enums\UserTypeEnums;
use App\Models\House;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        // $reservationRooms = (new ColumnChartModel())
        //     ->setTitle('Number of Reservation Rooms')
        //     ->addColumn('January', 100, '#f6ad55')
        //     ->addColumn('February', 200, '#fc8181')
        //     ->addColumn('March', 52, '#125df4')
        //     ->addColumn('April', 123, '#93cdf4')
        //     ->addColumn('May', 643, '#1a32f4')
        //     ->addColumn('June', 521, '#10cdf4')
        //     ->addColumn('July', 14, '#20cdf4')
        //     ->addColumn('August', 161, '#30cdf4')
        //     ->addColumn('September', 899, '#40cdf4')
        //     ->addColumn('November', 251, '#50cdf4')
        //     ->addColumn('December', 321, '#60cdf4');

        // $lineChartModel = (new LineChartModel())
        //     ->setTitle('Occupancy Rate')
        //     ->setAnimated(true)
        //     ->withOnPointClickEvent('onPointClick')
        //     ->setSmoothCurve()
        //     ->setXAxisVisible(true)
        //     ->setDataLabelsEnabled(false)
        //     ->sparklined();
        // ->addSlice('January', 100, '#f6ad55')
        // ->addSlice('February', 200, '#fc8181')
        // ->addSlice('March', 52, '#125df4')
        // ->addSlice('December', 321, '#60cdf4');

        $amountPerAccount = 500;

        $reservationsCurrenMonth = Reservation::whereBetween('checkIn', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])
            ->count();

        $houses = House::count();

        $rooms = Room::whereHas('getStatus', function ($query1) {
            $query1->whereIn('serial_id', [StatusEnums::VACANT, StatusEnums::OCCUPIED]);
        })->count();

        $clients = User::whereHas('userType', function ($query1) {
            $query1->where('serial_id', UserTypeEnums::USER);
        })
            ->count();

        $vacantRooms = Room::whereHas('getStatus', function ($query1) {
            $query1->where('serial_id', StatusEnums::VACANT);
        })
            ->count();

        $occupiedRooms = Room::whereHas('getStatus', function ($query1) {
            $query1->where('serial_id', StatusEnums::OCCUPIED);
        })
            ->count();

        $managements = User::whereHas('userType', function ($query1) {
            $query1->where('serial_id', UserTypeEnums::MANAGEMENT);
        })
            ->count();

        return view('livewire.admin.dashboard', [
            'reservationsCurrenMonth'   => $reservationsCurrenMonth,
            'houses'                    => $houses,
            'rooms'                     => $rooms,
            'clients'                   => $clients,
            'vacantRooms'               => $vacantRooms,
            'occupiedRooms'             => $occupiedRooms,
            'managements'               => $managements,
            'amountPerAccount'          => $amountPerAccount
        ]);
    }
}
