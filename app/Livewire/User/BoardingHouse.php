<?php

namespace App\Livewire\User;

use App\Enums\StatusEnums;
use App\Events\ReviewSent;
use App\Models\House;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Room;
use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
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

    #[Rule('required')]
    public $message;

    public $messagePaginate = 10;

    // public $totalMessages = [];

    // public $messages = [];

    public $messageApprovedCount;

    public $messageReviews;

    public $messageTotalReviews;

    public function mount()
    {
        $this->selectedAmenities = $this->selectedAmenities ?? [];


        if ($this->id) {
            $this->reloadReviews();
        }
    }

    public function loadMore()
    {
        $this->messagePaginate += 10;

        $this->reloadReviews();
    }

    public function reloadReviews()
    {
        $statuses = Status::where('serial_id', StatusEnums::APPROVED)->first();

        $this->messageApprovedCount = Reservation::where('houseId', $this->id)
            ->where('userId', Auth::id())
            ->where('statusId', $statuses->id)
            ->count();

        $this->messageTotalReviews = Review::where('houseId', $this->id)->count();

        $this->messageReviews = Review::with(['getUser' => function ($query1) {
            $query1->select(
                'id',
                'firstName',
                'lastName',
                'profileImage'
            );
        }])
            ->select(
                'id',
                'userId',
                'message',
                'created_at'
            )
            ->where('houseId', $this->id)
            ->take($this->messagePaginate)
            ->latest()
            ->get();
    }

    public function getListeners()
    {
        return [
            "echo:review.$this->id,ReviewSent" => 'broadcastReviewReceived'
        ];
    }

    public function broadcastReviewReceived($event)
    {
        if($this->id == $event['houseId']) {
            // dd($event);
            $this->reloadReviews();
        }

        // $this->showNewOrderNotification = true;
    }


    public function sendMessage()
    {
        $data = $this->validate();

        try {
            $newData = Review::create([
                'houseId' => $this->id,
                'userId'  => Auth::id(),
                'message' => $data['message']
            ]);

            // $this->dispatch('dispatch-reviews-sent')->self();
            broadcast(new ReviewSent($this->id, $newData));
            $this->reloadReviews();
            $this->message = '';
        } catch (Exception $e) {
            Log::debug($e);
        }
    }

    // #[On('dispatch-reviews-sent')]
    // public function updateReview()
    // {
    //     broadcast(new ReviewSent($this->id, Auth::id(), $this->message));
    // }

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
        $boardingHouses = House::with('getUser', 'getRatings')->findOrFail($this->id);

        $ratings = 0;

        // Calculate the ratings
        if ($boardingHouses->getRatings) {
            foreach ($boardingHouses->getRatings as $rate) {
                $ratings += $rate->rating;
            }

            // Only calculate for the house that contains ratings
            if (count($boardingHouses->getRatings) > 0) $ratings = $ratings / count($boardingHouses->getRatings);
        }

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

        // dd($rooms);

        return view('livewire.user.boarding-house', [
            'boardingHouses' => $boardingHouses,
            'rooms'          => $rooms,
            'ratings'        => $ratings,
        ]);
    }
}
