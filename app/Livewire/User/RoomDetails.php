<?php

namespace App\Livewire\User;

use App\Enums\StatusEnums;
use App\Livewire\User\Reservation as UserReservation;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Status;
use Carbon\Carbon;
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

    #[Rule('nullable')]
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
        foreach ($this->selectedAmenities as $key => $amenity) {
            $linkSelectedAmenity .= '&selectedAmenities[' . $key . ']=' . $amenity;
        }

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

        // Check the check in date
        if (Carbon::now()->format('Y-m-d') > Carbon::parse($data['checkIn'])->format('Y-m-d')) {
            $this->addError('checkIn', 'Check in must not be previous days');
            return;
        }

        if ($data['checkOut']) {
            // dd($data['checkOut']);
            // Check the check out date
            if (Carbon::parse($data['checkOut'])->format('Y-m-d') < Carbon::parse($data['checkIn'])->format('Y-m-d')) {
                $this->addError('checkOut', 'Check out must be greater than check in');
                return;
            }
        }

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


            $this->dispatch('success-reservation')->to(UserReservation::class);
        } catch (Exception $e) {
            Log::debug($e);
        }

        return $this->redirect('/reservations', navigate: true);
    }

    #[Layout('components.layouts.userAuth')]
    public function render()
    {

        $room = Room::with([
            'getRoomImages' => function ($query) {
                $query->select(
                    'roomId',
                    'imageUrl'
                );
            }, 'getHouse' => function ($query1) {
                $query1->select(
                    'id',
                    'userId',
                    'contact',
                    'paymentTypeId'
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
                    }, 'getSocialLinksInOrder' => function ($query5) {
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
                    }, 'getPaymentType' => function ($query5) {
                        $query5->select(
                            'id',
                            'serial_id',
                            'name'
                        );
                    }]);
            }, 'amenities',
            'getRoomUtilities' => function ($query6) {
                $query6->select('id', 'roomId', 'roomUtilityType', 'roomUtilityScope', 'price')
                    ->with(['getRoomUtilityType' => function ($query7) {
                        $query7->select('id', 'name');
                    }, 'getRoomUtilityScope' => function ($query8) {
                        $query8->select('id', 'name');
                    }])
                    ->orderBy('order', 'ASC');
            }, 'getPaymentAgreement' => function ($query7) {
                $query7->select('id', 'name');
            }
        ])->findOrFail($this->roomId);

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
