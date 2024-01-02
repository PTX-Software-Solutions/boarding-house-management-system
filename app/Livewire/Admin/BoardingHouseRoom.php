<?php

namespace App\Livewire\Admin;

use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class BoardingHouseRoom extends Component
{

    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function back()
    {
        return $this->redirect('/admin/boarding-houses', navigate: true);
    }

    public function createRooms()
    {
        return $this->redirect('/admin/boarding-houses/' . $this->id . '/rooms/create', navigate: true);
    }

    public function editRoom($roomId)
    {
        return $this->redirect('/admin/boarding-houses/' . $this->id . '/rooms/edit/' . $roomId, navigate: true);
    }

    #[On('removeBHRoom')]
    public function deleteActionRoom($id)
    {
        Room::where('id', $id)->delete();
    }


    public function deleteRoom($roomId)
    {
        $this->dispatch('deleteBHRoom', id: $roomId);
    }

    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        $rooms = DB::table('rooms AS r')
            ->select(
                'r.id',
                'r.name AS roomName',
                'r.monthlyDeposit',
                'rt.name AS roomTypeName',
                DB::raw('GROUP_CONCAT(a.name) AS amenityNames'),
                's.name AS statusName',
                'r.created_at'
            )
            ->leftJoin('room_types AS rt', 'r.roomTypeId', '=', 'rt.id')
            ->leftJoin('room_amenities AS ra', 'r.id', '=', 'ra.roomId')
            ->leftJoin('amenities AS a', 'ra.amenityId', '=', 'a.id')
            ->leftJoin('statuses AS s', 'r.statusId', '=', 's.id')
            ->groupBy('r.id')
            ->orderBy('created_at', 'DESC')
            ->where('houseId', $this->id)
            ->whereNull('r.deleted_at')
            ->paginate(10);

        return view('livewire.admin.boarding-house-room', [
            'rooms' => $rooms
        ]);
    }
}
