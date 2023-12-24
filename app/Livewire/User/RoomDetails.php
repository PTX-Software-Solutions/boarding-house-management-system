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
    }

    public function back()
    {
        return $this->redirect("/boarding-houses/" . $this->houseId . "?search=$this->search", navigate: true);
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
                'userId'
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
                }]);
        }, 'amenities'])->findOrFail($this->roomId);

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
