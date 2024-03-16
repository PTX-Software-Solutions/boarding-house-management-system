<?php

namespace App\Livewire\Management;

use App\Enums\StatusEnums;
use App\Exports\BoardingHouseExcelExport;
use App\Exports\ManagementBoardingHouseExcelExport;
use App\Models\House;
use Illuminate\Http\Request;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ManagementBoardingHouse extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $id;

    #[Url(history: true)]
    public $search;

    public function createBoardingHouse()
    {
        return $this->redirect('/management/boarding-houses/create', navigate: true);
    }

    public function closeBoardingHouse()
    {
        $this->dispatch('closeBoardingHouseModal');
    }

    public function rooms($id)
    {
        return $this->redirect('/management/boarding-houses/' . $id . '/rooms', navigate: true);
    }


    public function editBoardingHouse($id)
    {
        return $this->redirect('/management/boarding-houses/edit/' . $id, navigate: true);
    }

    #[On('removeBH')]
    public function deleteBh($id)
    {
        House::where('id', $id)->delete();
    }

    public function deleteBoardingHouse($id)
    {
        $this->dispatch('deleteBH', id: $id);
    }

    #[On('goOn-Delete')]
    public function delete($id)
    {
        House::where('id', $id)->delete();
    }

    public function exportPdfBoardingHouse(Request $request)
    {
        $search = $request->query('search') ?? false;
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
            ->when($search, function ($query3) use ($search) {
                $query3->where('houseName', 'LIKE', '%' . $search . '%');
            })
            ->where('userId', Auth::guard('management')->user()->id)
            ->latest()
            ->get()
            ->toArray();

        $pdf = PDF::loadView('pdf.boarding-house', ['boardingHouses' => $boardingHouses]);
        return $pdf->download('reservations' . Carbon::now()->format('YmdHis') . '.pdf');
    }

    public function exportExcelBoardingHouse()
    {
        return Excel::download(new ManagementBoardingHouseExcelExport($this->search), 'boarding_house' . Carbon::now()->format('YmdHis') . '.xlsx');
    }

    #[Layout('components.layouts.managementAuth')]
    public function render()
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
            ->with('getRatings')
            ->when($this->search, function ($query3) {
                $query3->where('houseName', 'LIKE', '%' . $this->search . '%');
            })
            ->where('userId', Auth::guard('management')->user()->id)
            ->latest()
            ->paginate(10);

        return view('livewire.management.management-boarding-house', [
            'boardingHouses' => $boardingHouses
        ]);
    }
}
