<?php

namespace App\Livewire\Management;

use App\Enums\UserTypeEnums;
use App\Models\DistanceTypes;
use App\Models\House;
use App\Models\HouseImage;
use App\Models\NearbyAttraction;
use App\Models\SocialMedia;
use App\Models\SocialMediaType;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

class ManagementBoardingHouseForm extends Component
{
    use WithFileUploads;

    public $houseName = '';

    public $contact = '';

    public $address = '';

    public $address2 = '';

    public $city = '';

    public $zip = '';

    public $uploadImage;

    public $oldImage = [];
    public $isEditMode = false;

    public $longitude = 123.31; // default longitude of dumaguete city
    public $latitude = 9.31;    // default latitude of dumaguete city

    public $id;

    public $attractionLists = [];

    public $socialLinks = [];

    public $currentTab = 1;

    protected $listeners = [
        'resetInputFields' => 'resetInput'
    ];

    public function rules()
    {
        return [
            'houseName' => 'required',
            'contact' => 'required',
            'address' => 'required',
            'address2' => 'nullable',
            'city' => 'required',
            'zip' => 'required',
            'uploadImage'   => 'nullable',
            'uploadImage.*' => 'nullable|max:1024',
            'attractionLists' => 'required|array',
            'attractionLists.*.name' => 'required',
            'attractionLists.*.distance' => 'required',
            'attractionLists.*.distanceType' => 'required',
            'socialLinks' => 'nullable|array',
            // 'socialLinks.*.link' => 'nullable',
            'socialLinks.*.link' => Rule::requiredIf(function () {
                // The link is required only if a social media account is provided
                return !empty($this->socialLinks) && is_array($this->socialLinks);
            }),
            'socialLinks.*.socialType' => Rule::requiredIf(function () {
                // The link is required only if a social media account is provided
                return !empty($this->socialLinks) && is_array($this->socialLinks);
            }),
        ];
    }

    public function messages()
    {
        return [
            'attractionLists.required' => 'The attraction field is required',
            'attractionLists.*.name.required' => 'The name field is required',
            'attractionLists.*.distance.required' => 'The distance field is required',
            'attractionLists.*.distanceType.required' => 'The distance type field is required',
            'socialLinks.*.link.required' => 'The social media link is required',
            'socialLinks.*.socialType' => 'The social media type is required'
        ];
    }

    public function back()
    {
        return $this->redirect('/management/boarding-houses', navigate: true);
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

    public function addSocialLink()
    {
        $this->socialLinks[] = [
            'link'  => null,
            'socialType' => null
        ];
    }

    public function removeSocialMedia($index)
    {
        unset($this->socialLinks[$index]);
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
        $house = House::with(['getNearbyAttractionInOrder' => function ($q1) {
            $q1->select('name', 'houseId', 'distance', 'distanceTypeId');
        }, 'getHousePhoto' => function ($q2) {
            $q2->select('houseId', 'imageUrl');
        }, 'getSocialLinksInOrder' => function ($q3) {
            $q3->select(
                'link',
                'socialMediaTypeId',
                'houseId'
            );
        }])->findOrFail($id);

        $this->id = $house->id;
        $this->houseName = $house->houseName;
        $this->contact = $house->contact;
        $this->address = $house->address;
        $this->address2 = $house->address2;
        $this->city = $house->city;
        $this->zip = $house->zip;
        $this->longitude = $house->longitude;
        $this->latitude = $house->latitude;
        $this->isEditMode = true;

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

        // Get the House Photos
        if (!$house->getHousePhoto->isEmpty()) {
            foreach ($house->getHousePhoto  as $key => $housePhoto) {
                $this->oldImage[$key] = $housePhoto->imageUrl;
            }
        }

        // Get the social links
        if (!$house->getSocialLinksInOrder->isEmpty()) {
            foreach ($house->getSocialLinksInOrder as $key => $socialLink) {
                $this->socialLinks[$key] = [
                    'link'  => $socialLink->link,
                    'socialType' => $socialLink->socialMediaTypeId
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
        $data = $this->validate();

        try {
            DB::beginTransaction();


            if ($this->id) {
                $bh = House::with('getNearbyAttractions', 'getHousePhoto', 'getSocialLinks')->findOrFail($this->id);

                $bh->update([
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

                    foreach ($data['attractionLists'] as $key => $attrList) {
                        NearbyAttraction::create([
                            'houseId' => $bh->id,
                            'name'  => $attrList['name'],
                            'order' => $key,
                            'distance' => (int)$attrList['distance'],
                            'distanceTypeId' => $attrList['distanceType']
                        ]);
                    }
                }

                // Remove all existing social links and insert new data
                if (!empty($data['socialLinks'])) {
                    foreach ($bh->getSocialLinks as $socialLink) {
                        $socialLink->delete();
                    }

                    foreach ($data['socialLinks'] as $key => $social) {
                        SocialMedia::create([
                            'link' => $social['link'],
                            'order' => $key,
                            'houseId' => $bh->id,
                            'socialMediaTypeId' => $social['socialType']
                        ]);
                    }
                }


                // Contains new image photo
                if (!is_null($data['uploadImage'])) {
                    // Remove all existing images and insert new data
                    if (!$bh->getHousePhoto->isEmpty()) {
                        foreach ($bh->getHousePhoto as $photo) {
                            $photo->delete();
                        }
                    }

                    // Insert the new photo
                    foreach ($data['uploadImage'] as $upload) {
                        HouseImage::create([
                            'houseId' => $bh->id,
                            'imageUrl' => $this->uploadImage($upload)
                        ]);
                    }
                }

                DB::commit();
                $this->dispatch('success-update');
            } else {
                $house = House::create([
                    'userId'    => Auth::guard('management')->user()->id,
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
                    foreach ($data['attractionLists'] as $key => $list) {
                        NearbyAttraction::create([
                            'houseId' => $house->id,
                            'name'  => $list['name'],
                            'order' => $key,
                            'distance' => (int)$list['distance'],
                            'distanceTypeId' => $list['distanceType']
                        ]);
                    }
                }

                if (!empty($data['uploadImage'])) {
                    foreach ($data['uploadImage'] as $upload) {
                        HouseImage::create([
                            'houseId' => $house->id,
                            'imageUrl' => $this->uploadImage($upload)
                        ]);
                    }
                }

                if (!empty($data['socialLinks'])) {
                    foreach ($data['socialLinks'] as $index => $socialLink) {
                        SocialMedia::create([
                            'link' => $socialLink['link'],
                            'order' => $index,
                            'houseId' => $house->id,
                            'socialMediaTypeId' => $socialLink['socialType']
                        ]);
                    }
                }

                DB::commit();
                $this->dispatch('success-insert');
            }

            return $this->redirect('/management/boarding-houses', navigate: true);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->redirect('/management/boarding-houses', navigate: true);
        }
    }

    public function removeUploadImage($index)
    {
        unset($this->uploadImage[$index]);
    }

    #[Layout('components.layouts.managementAuth')]
    public function render()
    {
        $distanceTypes = DistanceTypes::select(
            'id',
            'name'
        )
            ->orderBy('serial_id', 'ASC')
            ->get();

        $socialMediaTypes = SocialMediaType::select(
            'id',
            'name'
        )
            ->orderBy('serial_id', 'ASC')
            ->get();

        $homeOwners = User::whereHas('userType', function ($query) {
            $query->where('serial_id', UserTypeEnums::MANAGEMENT);
        })
            ->select(
                'id',
                'firstName',
                'lastName',
                'profileImage'
            )
            ->get();

        return view('livewire.management.management-boarding-house-form', [
            'homeOwners'        => $homeOwners,
            'distanceTypes'     => $distanceTypes,
            'socialMediaTypes'  => $socialMediaTypes,
        ]);
    }
}


// 'livewire.management.management-boarding-house-form'