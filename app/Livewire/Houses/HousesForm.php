<?php

namespace App\Livewire\Houses;

use App\Models\House;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class HousesForm extends Component
{
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

    protected $listeners = [
        // 'editBoardingHouse' => 'edit',
        'resetInputFields' => 'resetInput'
    ];

    public function back()
    {
        return $this->redirect('/boarding-house', navigate: true);
    }

    public function edit($id)
    {
        $house = House::findOrFail($id);

        $this->id = $house->id;
        $this->houseName = $house->houseName;
        $this->contact = $house->contact;
        $this->address = $house->address;
        $this->address2 = $house->address2;
        $this->city = $house->city;
        $this->zip = $house->zip;
        $this->longitude = $house->longitude;
        $this->latitude = $house->latitude;

        // $this->dispatch('updateCoordinates', [
        //     'longitude' => $this->longitude,
        //     'latitude'  => $this->latitude
        // ]);
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

        if ($id) {
            $this->edit($id);
        }
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->id) {

                $bh = House::findOrFail($this->id);

                $bh->update([
                    'houseName' => $this->houseName,
                    'contact'   => $this->contact,
                    'address'   => $this->address,
                    'address2'  => $this->address2,
                    'city'  => $this->city,
                    'zip'  => $this->zip,
                    'longitude' => $this->longitude,
                    'latitude' => $this->latitude
                ]);

                $this->dispatch('success-update');
            } else {
                House::create([
                    'houseName' => $this->houseName,
                    'contact'   => $this->contact,
                    'address'   => $this->address,
                    'address2'  => $this->address2,
                    'city'  => $this->city,
                    'zip'  => $this->zip,
                    'longitude' => $this->longitude,
                    'latitude' => $this->latitude
                ]);

                $this->dispatch('success-insert');
            }

            return $this->redirect('/boarding-house', navigate: true);
        } catch (Exception $e) {
            Log::debug($e);
            return $this->redirect('/boarding-house', navigate: true);
        }
    }

    #[Layout('components.layouts.userAuth')]
    public function render()
    {
        return view('livewire.houses.houses-form');
    }
}
