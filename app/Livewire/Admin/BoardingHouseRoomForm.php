<?php

namespace App\Livewire\Admin;

use App\Models\RoomType;
use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class BoardingHouseRoomForm extends Component
{
    use WithFileUploads;

    public $currentTab = 1;

    public $roomId;
    
    public $id;

    #[Rule('required')]
    public $nameNumber;

    #[Rule('required')]
    public $monthDeposit;

    #[Rule('required')]
    public $roomType;

    #[Rule('required')]
    public $status;

    #[Rule(['uploadImage.*' => 'image|max:1024'])] // 1MB Max
    public $uploadImage = [];

    #[Rule([
        'roomAmmenities' => 'required|array',
        'roomAmmenities.*.name' => 'required',
    ], message: [
        'roomAmmenities.required' => 'The room ammenities field is required',
        'roomAmmenities.*.name.required' => 'The name field is required',
    ])]
    public $roomAmmenities = [];

    public function addRoomAmmenities()
    {
        $this->roomAmmenities[] = [
            'name'  => null,
        ];
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
        $this->addRoomAmmenities();

        if ($id) {
            // $this->edit($id);
        }
    }

    public function save()
    {
        try {
            $this->validate();
        } catch (Exception $e) {
            //throw $th;
        }
    }

    public function removeRoomAmmenities($index)
    {
        unset($this->roomAmmenities[$index]);
    }

    public function removeUploadImage($index)
    {
        unset($this->uploadImage[$index]);
    }

    public function changeTab($tabNum)
    {
        $this->currentTab = $tabNum;
    }

    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        $statuses = Status::select('id', 'name')->get();
        $roomTypes = RoomType::select('id', 'name')->get();

        return view('livewire.admin.boarding-house-room-form', [
            'statuses' => $statuses,
            'roomTypes' => $roomTypes
        ]);
    }
}
