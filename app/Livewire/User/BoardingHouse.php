<?php

namespace App\Livewire\User;

use App\Models\House;
use App\Models\Room;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BoardingHouse extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search;

    public $id;

    public function mount($id)
    {
        $this->id = $id;

        // if ($this->search) {

        // }

        // dd($this->boardingHouse, $this->rooms);
    }

    public function back()
    {
        return $this->redirect('/?search='. $this->search, navigate: true);
    }

    #[Layout('components.layouts.userAuth')]
    public function render()
    {
        $boardingHouses = House::with('getUser')->findOrFail($this->id);



        $rooms = Room::select(
            'id',
            'name',
            'monthlyDeposit',
            'houseId',
            'roomTypeId'
        )
        ->with(['getRoomType' => function ($query) {
            $query->select(
                'id',
                'name'
            );
        }, 'getRoomImages' => function ($query2) {
            $query2->select(
                'roomId',
                'imageUrl'
            );
        }])
        ->where('houseId', $this->id)
        ->orderBy('created_at', 'DESC')
        ->simplePaginate(6);

        return view('livewire.user.boarding-house', [
            'boardingHouses' => $boardingHouses,
            'rooms'          => $rooms
        ]);
    }
}
