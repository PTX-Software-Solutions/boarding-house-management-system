<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;

class BoardingHouseRoom extends Component
{

    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function createRooms()
    {
        return $this->redirect('/admin/boarding-houses/' . $this->id . '/rooms/create', navigate: true);
    }

    #[Layout('components.layouts.adminAuth')]
    public function render()
    {

        return view('livewire.admin.boarding-house-room');
    }
}
