<?php

namespace App\Livewire\Admin;

use App\Enums\UserTypeEnums;
use App\Models\DistanceTypes;
use App\Models\House;
use App\Models\NearbyAttraction;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class BoardingHouseForm extends Component
{
    #[Rule('required', message: 'The home owner is required')]
    public $userId;

    #[Rule('required')]
    public $houseName = '';

    #[Rule('required')]
    public $contact = '';

    #[Rule('required')]
    public $address = '';

    #[Rule('nullable')]
    public $address2 = '';

    #[Rule('required')]
    public $city = '';

    #[Rule('required')]
    public $zip = '';

    public $longitude = 123.31; // default longitude of dumaguete city
    public $latitude = 9.31;    // default latitude of dumaguete city

    public $id;

    #[Rule([
        'attractionLists' => 'required|array',
        'attractionLists.*.name' => 'required',
        'attractionLists.*.distance' => 'required',
        'attractionLists.*.distanceType' => 'required'
    ], message: [
        'attractionLists.required' => 'The attraction field is required',
        'attractionLists.*.name.required' => 'The name field is required',
        'attractionLists.*.distance.required' => 'The distance field is required',
        'attractionLists.*.distanceType.required' => 'The distance type field is required'
    ])]
    public $attractionLists = [];

    public $currentTab = 1;

    protected $listeners = [
        'resetInputFields' => 'resetInput'
    ];

    public function back()
    {
        return $this->redirect('/admin/boarding-houses', navigate: true);
    }

    public function changeTab(int $tabNum)
    {
        $this->currentTab = $tabNum;
    }

    public function addAttraction()
    {
        $this->attractionLists[] = [
            'name'  => null,
            'distance' => null,
            'distanceType' => null
        ];
    }

    public function removeAttraction($index)
    {
        unset($this->attractionLists[$index]);
    }

    public function hydrate()
    {
        $this->dispatch('init-select2');
    }

    public function edit($id): void
    {
        $house = House::with(['getNearbyAttractionInOrder' => function ($query) {
            $query->select('name', 'houseId', 'distance', 'distanceTypeId');
        }])->findOrFail($id);

        $this->id = $house->id;
        $this->userId = $house->userId;
        $this->houseName = $house->houseName;
        $this->contact = $house->contact;
        $this->address = $house->address;
        $this->address2 = $house->address2;
        $this->city = $house->city;
        $this->zip = $house->zip;
        $this->longitude = $house->longitude;
        $this->latitude = $house->latitude;

        // Get the NearbyAttraction
        if (!$house->getNearbyAttractionInOrder->isEmpty()) {
            foreach ($house->getNearbyAttractionInOrder as $key => $attraction) {
                $this->attractionLists[$key] = [
                    'name' => $attraction->name,
                    'distance' => $attraction->distance,
                    'distanceType' => $attraction->distanceTypeId
                ];
            }
        }
    }

    public function resetInput()
    {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function mount($id = null)
    {
        $this->resetInput();
        $this->reset();
        $this->addAttraction();

        if ($id) {
            $this->edit($id);
        }
    }

    public function save()
    {
        $data = $this->validate();

        try {
            DB::beginTransaction();


            if ($this->id) {
                $bh = House::with('getNearbyAttractions')->findOrFail($this->id);

                $bh->update([
                    'userId'    => $data['userId'],
                    'houseName' => $data['houseName'],
                    'contact'   => $data['contact'],
                    'address'   => $data['address'],
                    'address2'  => $data['address2'],
                    'city'  => $data['city'],
                    'zip'  => $data['zip'],
                    'longitude' => $this->longitude,
                    'latitude' => $this->latitude
                ]);

                // Remove all existing nearby attractions and insert new data
                if (!$bh->getNearbyAttractions->isEmpty()) {
                    foreach ($bh->getNearbyAttractions as $attraction) {
                        $attraction->delete();
                    }

                    foreach ($data['attractionLists'] as $key => $data) {
                        NearbyAttraction::create([
                            'houseId' => $bh->id,
                            'name'  => $data['name'],
                            'order' => $key,
                            'distance' => (int)$data['distance'],
                            'distanceTypeId' => $data['distanceType']
                        ]);
                    }
                }

                DB::commit();
                $this->dispatch('success-update');
            } else {
                $house = House::create([
                    'userId'    => $data['userId'],
                    'houseName' => $data['houseName'],
                    'contact'   => $data['contact'],
                    'address'   => $data['address'],
                    'address2'  => $data['address2'],
                    'city'  => $data['city'],
                    'zip'  => $data['zip'],
                    'longitude' => $this->longitude,
                    'latitude' => $this->latitude
                ]);

                if (!empty($data['attractionLists'])) {
                    foreach ($data['attractionLists'] as $key => $data) {
                        NearbyAttraction::create([
                            'houseId' => $house->id,
                            'name'  => $data['name'],
                            'order' => $key,
                            'distance' => (int)$data['distance'],
                            'distanceTypeId' => $data['distanceType']
                        ]);
                    }
                }

                DB::commit();
                $this->dispatch('success-insert');
            }

            return $this->redirect('/admin/boarding-houses', navigate: true);
        } catch (Exception $e) {
            Log::debug($e);
            DB::rollBack();
            return $this->redirect('/admin/boarding-houses', navigate: true);
        }
    }

    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        $distanceTypes = DistanceTypes::select(
            'id',
            'name'
        )->get();

        $homeOwners = User::whereHas('userType', function ($query) {
            $query->where('name', UserTypeEnums::MANAGEMENT);
        })
            ->select(
                'id',
                'firstName',
                'lastName',
                'profileImage'
            )
            ->get();

        return view('livewire.admin.boarding-house-form', [
            'homeOwners'    => $homeOwners,
            'distanceTypes' => $distanceTypes
        ]);
    }
}
