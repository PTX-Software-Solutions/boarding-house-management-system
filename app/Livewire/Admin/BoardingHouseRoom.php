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
        $rooms = Room::with([
            'getRoomType' => function ($query1) {
                $query1->select('id', 'serial_id', 'name');
            }
            , 'amenities',
            'getStatus' => function ($query2) {
                $query2->select('id', 'serial_id', 'name');
            }
        ])->where('houseId', $this->id)
            ->latest()
            ->paginate(10);

        return view('livewire.admin.boarding-house-room', [
            'rooms' => $rooms
        ]);
    }
}
