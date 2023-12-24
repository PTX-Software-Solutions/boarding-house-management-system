<?php

namespace App\Livewire\Admin;

use App\Enums\StatusEnums;
use App\Models\Reservation as ModelsReservation;
use App\Models\Status;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Reservation extends Component
{

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

    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        $reservations = ModelsReservation::with('getUser', 'getHouse', 'getRoom', 'getStatus')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        return view('livewire.admin.reservation', [
            'reservations' => $reservations
        ]);
    }
}
