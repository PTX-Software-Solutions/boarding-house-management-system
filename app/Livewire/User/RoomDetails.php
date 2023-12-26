<?php

namespace App\Livewire\User;

use App\Enums\StatusEnums;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;

class RoomDetails extends Component
{

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

    public $houseId;

    public $roomId;

    #[Rule('required')]
    public $checkIn;

    #[Rule('nullable')]
    public $checkOut;

    #[Rule('required')]
    public $note;

    public function mount($id, $roomId)
    {
        $this->houseId = $id;
        $this->roomId = $roomId;

        $this->selectedAmenities = $this->selectedAmenities ?? [];
    }

    public function back()
    {
        $linkSelectedAmenity = '';
        // dd($this->selectedAmenities);
        // $this->selectedAmenities = !is_null($this->selectedAmenities) ? explode(",", $this->selectedAmenities) : [];

        foreach ($this->selectedAmenities as $key => $amenity) {
            $linkSelectedAmenity .= '&selectedAmenities[' . $key . ']=' . $amenity;
        }


        // dd($linkSelectedAmenity, $this->selectedAmenities);

        return $this->redirect(
            '/boarding-houses/' . $this->houseId .
                '?search=' . $this->search .
                '&priceRange=' . $this->priceRange .
                '&roomType=' . $this->roomType .
                '&selectedDistance=' . $this->selectedDistance .
                $linkSelectedAmenity,
            navigate: true
        );
    }

    public function save()
    {

        $data = $this->validate();

        try {
            $statusDefault = Status::where('serial_id', StatusEnums::PENDING)->first();
            Reservation::create([
                'userId'    => Auth::id(),
                'houseId'   => $this->houseId,
                'roomId'    => $this->roomId,
                'statusId'  => $statusDefault->id,
                'checkIn'   => $data['checkIn'],
                'checkOut'  => $data['checkOut'],
                'note'      => $data['note']
            ]);


            $this->dispatch('success-reservation');
            return $this->redirect('/reservations', navigate: true);
        } catch (Exception $e) {
            Log::debug($e);
        }
    }

    #[Layout('components.layouts.userAuth')]
    public function render()
    {

        $room = Room::with(['getRoomImages' => function ($query) {
            $query->select(
                'roomId',
                'imageUrl'
            );
        }, 'getHouse' => function ($query1) {
            $query1->select(
                'id',
                'userId',
                'contact'
            )
                ->with(['getUser' => function ($query2) {
                    $query2->select(
                        'id',
                        'firstName',
                        'lastName',
                        'profileImage'
                    );
                }, 'nearbyAttraction' => function ($query3) {
                    $query3->select(
                        'houseId',
                        'name',
                        'distance',
                        'distanceTypeId'
                    )
                        ->orderBy('order', 'ASC')
                        ->with(['distanceTypes' => function ($query4) {
                            $query4->select(
                                'id',
                                'name'
                            );
                        }]);
                }, 'getSocialLinks' => function ($query5) {
                    $query5->select(
                        'houseId',
                        'link',
                        'socialMediaTypeId'
                    )
                        ->with(['getSocialMediaType' => function ($query6) {
                            $query6->select(
                                'id',
                                'name',
                                'serial_id'
                            );
                        }]);
                }]);
        }, 'amenities'])->findOrFail($this->roomId);

        // dd($room);

        $statuses = Status::whereIn('serial_id', [StatusEnums::PENDING, StatusEnums::FOR_APPROVAL])->pluck('id')->toArray();

        $reservations = Reservation::where('houseId', $this->houseId)
            ->where('userId', Auth::id())
            ->whereIn('statusId', $statuses)
            ->pluck('roomId')
            ->toArray();

        return view('livewire.user.room-details', [
            'room'          => $room,
            'reservations'  => $reservations
        ]);
    }
}
