<?php

namespace App\Livewire\User;

use App\Enums\StatusEnums;
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

    #[Url(history: true)]
    public $priceRange;

    #[Url(history: true)]
    public $roomType;

    #[Url(history: true)]
    public $selectedDistance;

    #[Url(history: true)]
    public $selectedAmenities;

    public $id;

    public function mount()
    {
        $this->selectedAmenities = $this->selectedAmenities ?? [];
        // dd($this->selectedAmenities);
        // $this->selectedAmenities = !is_null($this->selectedAmenities) ? explode(",", $this->selectedAmenities) : [];
    }

    public function back()
    {

        $linkSelectedAmenity = '';

        foreach ($this->selectedAmenities as $key => $amenity) {
            $linkSelectedAmenity .= '&selectedAmenities[' . $key . ']=' . $amenity;
        }

        return $this->redirect('/?search=' . $this->search .
            '&priceRange=' . $this->priceRange .
            '&roomType=' . $this->roomType .
            '&selectedDistance=' . $this->selectedDistance .
            $linkSelectedAmenity, navigate: true);
    }

    #[Layout('components.layouts.userAuth')]
    public function render()
    {
        $boardingHouses = House::with('getUser')->findOrFail($this->id);

        $selectedAmenities = $this->selectedAmenities;

        $rooms = Room::select(
            'id',
            'name',
            'monthlyDeposit',
            'houseId',
            'roomTypeId',
            'statusId'
        )
            ->with([
                'getRoomType' => function ($query) {
                    $query->select(
                        'id',
                        'name'
                    );
                }, 'getRoomImages' => function ($query2) {
                    $query2->select(
                        'roomId',
                        'imageUrl'
                    );
                },
                'amenities' => function ($query3) use ($selectedAmenities) {
                    $query3->when(!empty($selectedAmenities), function ($q) use ($selectedAmenities) {
                        $q->whereIn('name', $selectedAmenities);
                    });
                },
                'amenities' => function ($query4) use ($selectedAmenities) {
                    $query4->when(!empty($selectedAmenities), function ($q) use ($selectedAmenities) {
                        $q->with(['rooms' => function ($query5) use ($selectedAmenities) {
                            $query5->whereIn('name', $selectedAmenities);
                        }]);
                    });
                }
            ])
            ->whereHas('getStatus', function ($query9) {
                $query9->where('serial_id', StatusEnums::VACANT);
            })
            ->where('houseId', $this->id)
            ->when($this->roomType, function ($query6) {
                $query6->where('roomTypeId', '=', $this->roomType);
            })
            ->when(!empty($selectedAmenities), function ($query7) use ($selectedAmenities) {
                $query7->whereHas('amenities', function ($query8) use ($selectedAmenities) {
                    $query8->whereIn('id', $selectedAmenities);
                });
            })
            ->where('monthlyDeposit', '<=', $this->priceRange)
            ->orderBy('created_at', 'DESC')
            ->simplePaginate(6);

        return view('livewire.user.boarding-house', [
            'boardingHouses' => $boardingHouses,
            'rooms'          => $rooms
        ]);
    }
}
// ->whereHas('getStatus', function ($query4) {
//     $query4->where('serial_id', StatusEnums::VACANT);
// })