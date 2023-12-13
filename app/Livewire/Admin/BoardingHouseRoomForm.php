<?php

namespace App\Livewire\Admin;

use App\Enums\StatusEnums;
use App\Models\Amenity;
use App\Models\Room;
use App\Models\RoomAmenity;
use App\Models\roomImage;
use App\Models\RoomType;
use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class BoardingHouseRoomForm extends Component
{
    use WithFileUploads;

    public $currentTab = 1;

    public $roomId;

    public $id;
    public $oldImage = [];
    public $isEditMode = false;

    #[Rule('required')]
    public $nameNumber;

    #[Rule('required')]
    public $monthDeposit;

    #[Rule('required')]
    public $roomType;

    #[Rule('required')]
    public $status;

    #[Rule([
        'uploadImage'   => 'nullable',
        'uploadImage.*' => 'nullable|max:1024'
    ], onUpdate: false)]
    public $uploadImage;

    // #[Rule(['nullable'])]
    // public $uploadImage;

    #[Rule('required')]
    public $roomAmenities = [];

    public function resetInput()
    {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function back()
    {
        return $this->redirect('/admin/boarding-houses/' . $this->id . '/rooms', navigate: true);
    }

    public function mount($id = null, $roomId = null)
    {
        $this->resetInput();

        if ($id) $this->id = $id;

        if ($roomId) {
            $this->roomId = $roomId;
            $this->editRoom($roomId);
        }
    }

    public function editRoom($roomId)
    {
        $room = Room::with(['amenities' => function ($q1) {
            $q1->select('id');
        }, 'getRoomImages' => function ($q2) {
            $q2->select('roomId', 'imageUrl');
        }])->findOrFail($this->roomId);

        $this->nameNumber = $room->name;
        $this->monthDeposit = $room->monthlyDeposit;
        $this->roomType = $room->roomTypeId;
        $this->status = $room->statusId;
        $this->isEditMode = true;

        if (!$room->amenities->isEmpty()) {
            $this->roomAmenities = $room->amenities->pluck('id')->toArray();
        }

        if (!$room->getRoomImages->isEmpty()) {
            foreach ($room->getRoomImages as $key => $room) {
                $this->oldImage[$key] = $room->imageUrl;
            }
        }
    }

    public function uploadImage($image)
    {
        if ($image) {
            $randomName = Str::random(20);
            $extension = $image->getClientOriginalExtension();
            $newName = $randomName . '.' . $extension;

            // $image->storeAs('photos/client/', $newName, 's3');
            $image->storeAs('public/images/', $newName);
        } else {
            // Default Image Name
            $newName = env('DEFAULT_IMAGE_NAME');
        }

        return $newName;
    }

    public function save()
    {
        $validated = $this->validate();

        try {
            DB::beginTransaction();

            if ($this->roomId) {

                $room = Room::with('amenities', 'getRoomImages')->findOrFail($this->roomId);

                $room->update([
                    'name'              => $validated['nameNumber'],
                    'monthlyDeposit'    => $validated['monthDeposit'],
                    'houseId'           => $this->id,
                    'roomTypeId'        => $validated['roomType'],
                    'statusId'          => $validated['status']
                ]);

                $room->amenities()->sync($validated['roomAmenities']);

                // Contains new image photo
                if (!is_null($validated['uploadImage'])) {
                    if (!$room->getRoomImages->isEmpty()) {
                        foreach ($room->getRoomImages as $photo) {
                            $photo->delete();
                        }
                    }

                    foreach ($validated['uploadImage'] as $upload) {
                        roomImage::create([
                            'roomId' => $room->id,
                            'imageUrl' => $this->uploadImage($upload)
                        ]);
                    }
                }

                DB::commit();
                $this->dispatch('success-update');
            } else {

                $room = Room::create([
                    'name'              => $validated['nameNumber'],
                    'monthlyDeposit'    => $validated['monthDeposit'],
                    'houseId'           => $this->id,
                    'roomTypeId'        => $validated['roomType'],
                    'statusId'          => $validated['status']
                ]);

                foreach ($validated['roomAmenities'] as $amenityId) {
                    RoomAmenity::create([
                        'roomId'    => $room->id,
                        'amenityId' => $amenityId
                    ]);
                }

                if (!empty($validated['uploadImage'])) {
                    foreach ($validated['uploadImage'] as $upload) {
                        roomImage::create([
                            'roomId' => $room->id,
                            'imageUrl' => $this->uploadImage($upload)
                        ]);
                    }
                }

                DB::commit();
                $this->dispatch('success-insert');
            }

            return $this->redirect('/admin/boarding-houses/' . $this->id . '/rooms', navigate: true);
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug($e);
        }
    }

    // public function removeUploadImage($index)
    // {
    //     unset($this->uploadImage[$index]);
    // }

    public function removeUploadImage()
    {
        $this->uploadImage = [];
    }

    public function changeTab($tabNum)
    {
        $this->currentTab = $tabNum;
    }

    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        $statuses = Status::select('id', 'name')
            ->whereIn('serial_id', [StatusEnums::VACANT, StatusEnums::OCCUPIED])
            ->get();
        $amenities = Amenity::select('id', 'serial_id', 'name')->get();
        $roomTypes = RoomType::select('id', 'name')->get();

        return view('livewire.admin.boarding-house-room-form', [
            'statuses' => $statuses,
            'roomTypes' => $roomTypes,
            'amenities' => $amenities
        ]);
    }
}
