<?php

namespace App\Livewire\Management;

use App\Enums\StatusEnums;
use App\Exports\ManagementReservationExcelExport;
use App\Exports\UsersExport;
use App\Models\Reservation;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class ManagementReservation extends Component
{

    #[Url(history: true)]
    public $search;

    public function createReservation()
    {
        return $this->redirect('/management/reservations/create', navigate: true);
    }

    public function cancelReservation(string $id)
    {
        $this->dispatch('cancelRes', id: $id);
    }

    public function forApprovalReservation(string $id)
    {
        $this->dispatch('forApproval', id: $id);
    }

    public function editReservation(string $id)
    {
        return $this->redirect('/management/reservations/edit/' . $id, navigate: true);
    }

    #[On('cancelReserv')]
    public function cancelReservFunc($id)
    {
        $status = Status::where('serial_id', StatusEnums::CANCELLED)->first();

        Reservation::where('id', $id)->update([
            'statusId' => $status->id
        ]);
    }

    #[On('forApprovalRes')]
    public function forApproval($id)
    {
        $status = Status::where('serial_id', StatusEnums::FOR_APPROVAL)->first();

        Reservation::where('id', $id)->update([
            'statusId' => $status->id
        ]);
    }

    public function exportExcelReservation()
    {
        return Excel::download(new ManagementReservationExcelExport($this->search), 'reservations' . Carbon::now()->format('YmdHis') . '.xlsx');
    }

    public function exportPdfReservation(Request $request)
    {
        $search = $request->query('search') ?? false;

        $reservations = Reservation::with('getUser', 'getHouse', 'getRoom', 'getStatus')
            ->orderBy('created_at', 'DESC')
            ->whereHas('getHouse', function ($query3) {
                $query3->where('userId', Auth::guard('management')->user()->id);
            })
            ->when($search, function ($query) use ($search) {
                $query->whereHas('getUser', function ($query1) use ($search) {
                    $query1->where('firstName', 'LIKE', '%' . $search . '%')
                        ->orWhere('lastName', 'LIKE', '%' . $search . '%');
                })
                    ->orWhereHas('getHouse', function ($query2) use ($search) {
                        $query2->where('userId', Auth::guard('management')->user()->id)
                            ->where('houseName', 'LIKE', '%' . $search . '%');
                    });
            })
            ->get()
            ->toArray();

        $pdf = PDF::loadView('pdf.reservations', ['reservations' => $reservations]);
        return $pdf->download('reservations' . Carbon::now()->format('YmdHis') . '.pdf');
    }

    #[Layout('components.layouts.managementAuth')]
    public function render()
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
            ->paginate(10);
        return view('livewire.management.management-reservation', [
            'reservations' => $reservations
        ]);
    }
}
