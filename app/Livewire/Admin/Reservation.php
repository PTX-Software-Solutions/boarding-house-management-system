<?php

namespace App\Livewire\Admin;

use App\Enums\StatusEnums;
use App\Exports\UsersExport;
use App\Models\Reservation as ModelsReservation;
use App\Models\Status;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Livewire\Attributes\Url;

class Reservation extends Component
{

    #[Url(history: true)]
    public $search;

    public function createReservation()
    {
        return $this->redirect('/admin/reservations/create', navigate: true);
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
        return $this->redirect('/admin/reservations/edit/' . $id, navigate: true);
    }

    #[On('cancelReserv')]
    public function cancelReservFunc($id)
    {
        $status = Status::where('serial_id', StatusEnums::CANCELLED)->first();

        ModelsReservation::where('id', $id)->update([
            'statusId' => $status->id
        ]);
    }

    #[On('forApprovalRes')]
    public function forApproval($id)
    {
        $status = Status::where('serial_id', StatusEnums::FOR_APPROVAL)->first();

        ModelsReservation::where('id', $id)->update([
            'statusId' => $status->id
        ]);
    }

    public function exportExcelReservation()
    {
        return Excel::download(new UsersExport($this->search), 'reservations' . Carbon::now()->format('YmdHis') . '.xlsx');
    }

    public function exportPdfReservation(Request $request)
    {
        $search = $request->query('search') ?? false;

        $reservations = ModelsReservation::with('getUser', 'getHouse', 'getRoom', 'getStatus')
            ->orderBy('created_at', 'DESC')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('getUser', function ($query1) use ($search) {
                    $query1->where('firstName', 'LIKE', '%' . $search . '%')
                        ->orWhere('lastName', 'LIKE', '%' . $search . '%');
                })
                    ->orWhereHas('getHouse', function ($query2) use ($search) {
                        $query2->where('houseName', 'LIKE', '%' . $search . '%');
                    });
            })
            ->get()
            ->toArray();

        $pdf = PDF::loadView('pdf.reservations', ['reservations' => $reservations]);
        return $pdf->download('reservations' . Carbon::now()->format('YmdHis') . '.pdf');
    }

    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        $reservations = ModelsReservation::with('getUser', 'getHouse', 'getRoom', 'getStatus')
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
            ->paginate(10);
        return view('livewire.admin.reservation', [
            'reservations' => $reservations
        ]);
    }
}
