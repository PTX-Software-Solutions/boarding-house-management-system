<?php

namespace App\Livewire\Admin;

use App\Enums\StatusEnums;
use App\Models\Amenity;
use App\Models\PaymentAgreementType;
use App\Models\Room;
use App\Models\RoomAmenity;
use App\Models\roomImage;
use App\Models\RoomType;
use App\Models\RoomUtility;
use App\Models\RoomUtilityScope;
use App\Models\RoomUtilityType;
use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule as ValidationRule;

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
    public $paymentAgreementType;

    #[Rule('required')]
    public $status;

    #[Rule([
        'uploadImage'   => 'nullable',
        'uploadImage.*' => 'nullable|max:1024'
    ], onUpdate: false)]
    public $uploadImage;

    #[Rule('required')]
    public $roomAmenities = [];

    public $roomUtilities = [];

    public $roomUtilitiesCheck = [];

    public $selectedUtilities = [];

    public function addUtilities()
    {
        $this->roomUtilities[] = [
            'id'    => null,
            'utilityType'  => null,
            'scope' => null,
            'scopeSerialId' => null,
            'price' => null,
        ];
    }

    public function removeRoomUtility($index)
    {
        unset($this->roomUtilities[$index]);
    }

    public function updatedRoomUtilities($data, $key)
    {
        $currentIndex = (int) explode(".", $key)[0];
        $rawKey = explode(".", $key)[1];

        if ($rawKey === "utilityType") {
            array_push($this->selectedUtilities, $data);
        }

        if ($rawKey === "scope") {
            $number = $this->roomUtilitiesCheck[$data];

            $this->roomUtilities[$currentIndex]['scopeSerialId'] = $number;
        }
    }


    public function rules()
    {
        return [
            'roomUtilities' => 'nullable|array',
            'roomUtilities.*.id' => 'nullable',
            'roomUtilities.*.scopeSerialId' => 'nullable',
            'roomUtilities.*.utilityType' => ValidationRule::requiredIf(function () {
                return !empty($this->roomUtilities) && is_array($this->roomUtilities);
            }),
            'roomUtilities.*.scope' => ValidationRule::requiredIf(function () {
                return !empty($this->roomUtilities) && is_array($this->roomUtilities);
            }),
            'roomUtilities.*.price' => [
                function () {
                    foreach ($this->roomUtilities as $item) {
                        if ($item['scopeSerialId'] === 2) {
                            return 'required';
                        } else {
                            return 'nullable';
                        }
                    }
                }
            ],
        ];
    }


    public function messages()
    {
        return [
            'roomUtilities.*.utilityType' => 'The utility type is required.',
            'roomUtilities.*.scope' => 'The utility scope is required.',
            'roomUtilities.*.price' => 'The utility price is required.',
        ];
    }

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

        $roomScope = RoomUtilityScope::select('id', 'serial_id', 'name')->get();

        $this->roomUtilitiesCheck = $roomScope->flatMap(function ($item) {
            return [$item->id => $item->serial_id];
        });

        if ($id) $this->id = $id;

        if ($roomId) {
            $this->roomId = $roomId;
            $this->editRoom($roomId);
        }
    }

    public function editRoom()
    {
        $room = Room::with(['amenities' => function ($q1) {
            $q1->select('id');
        }, 'getRoomImages' => function ($q2) {
            $q2->select('roomId', 'imageUrl');
        }, 'getRoomUtilities' => function ($q3) {
            $q3->select('id', 'roomId', 'roomUtilityType', 'roomUtilityScope', 'price')
                ->orderBy('order', 'ASC');
        }])
            ->findOrFail($this->roomId);

        $this->nameNumber = $room->name;
        $this->monthDeposit = $room->monthlyDeposit;
        $this->paymentAgreementType = $room->paymentAgreementId;
        $this->roomType = $room->roomTypeId;
        $this->status = $room->statusId;
        $this->isEditMode = true;

        if (!$room->getRoomUtilities->isEmpty()) {
            foreach ($room->getRoomUtilities as $index => $utilities) {

                array_push($this->selectedUtilities, $utilities->roomUtilityType);

                $number = $this->roomUtilitiesCheck[$utilities->roomUtilityScope];

                $this->roomUtilities[$index] = [
                    'id'            => $utilities->id,
                    'utilityType'   => $utilities->roomUtilityType,
                    'scope'         => $utilities->roomUtilityScope,
                    'scopeSerialId' => $number,
                    'price'         => $utilities->price
                ];
            }
        }

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

                $room = Room::with('amenities', 'getRoomImages', 'getRoomUtilities')->findOrFail($this->roomId);

                $room->update([
                    'name'              => $validated['nameNumber'],
                    'monthlyDeposit'    => $validated['monthDeposit'],
                    'houseId'           => $this->id,
                    'roomTypeId'        => $validated['roomType'],
                    'paymentAgreementId'=> $validated['paymentAgreementType'],
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

                $existingUtilities = $room->getRoomUtilities;

                // Contains new room utilities
                if (!empty($validated['roomUtilities'])) {
                    foreach ($validated['roomUtilities'] as $key => $utilityData) {
                        $utility = RoomUtility::updateOrCreate(
                            ['id' => $utilityData['id']],
                            [
                                'roomId'    => $room->id,
                                'roomUtilityType' => $utilityData['utilityType'],
                                'roomUtilityScope'  => $utilityData['scope'],
                                'price' => $utilityData['scopeSerialId'] === 2 ? $utilityData['price'] : null,
                                'order' => $key
                            ]
                        );

                        $existingUtilities = $existingUtilities->except($utility->id);
                    }

                    $existingUtilities->each(function ($existingUtility) {
                        $existingUtility->delete();
                    });
                }

                DB::commit();
                $this->dispatch('success-update');
            } else {

                $room = Room::create([
                    'name'              => $validated['nameNumber'],
                    'monthlyDeposit'    => $validated['monthDeposit'],
                    'houseId'           => $this->id,
                    'roomTypeId'        => $validated['roomType'],
                    'paymentAgreementId'=> $validated['paymentAgreementType'],
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

                if (!empty($validated['roomUtilities'])) {
                    foreach ($validated['roomUtilities'] as $key => $utility) {
                        RoomUtility::create([
                            'roomId'    => $room->id,
                            'roomUtilityType' => $utility['utilityType'],
                            'roomUtilityScope'  => $utility['scope'],
                            'price' =>   $utility['price'],
                            'order' => $key
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
        $roomUtilitiesTypes = RoomUtilityType::select('id', 'name')->get();
        $roomUtilitiesScopes = RoomUtilityScope::select('id', 'name')->get();
        $paymentAgreements = PaymentAgreementType::select('id', 'name')->get();

        return view('livewire.admin.boarding-house-room-form', [
            'statuses'              => $statuses,
            'roomTypes'             => $roomTypes,
            'amenities'             => $amenities,
            'roomUtilitiesTypes'    => $roomUtilitiesTypes,
            'roomUtilitiesScopes'   => $roomUtilitiesScopes,
            'paymentAgreements'     => $paymentAgreements,
        ]);
    }
}
