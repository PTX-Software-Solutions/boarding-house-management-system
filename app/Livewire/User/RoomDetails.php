<?php

namespace App\Livewire\User;

use Livewire\Attributes\Layout;
use Livewire\Component;

class RoomDetails extends Component
{

    public function mount($id, $roomId)
    {
        // dd($id, $roomId);
    }

    public function back()
    {

    }

    #[Layout('components.layouts.userAuth')]
    public function render()
    {
        return view('livewire.user.room-details');
    }
}
