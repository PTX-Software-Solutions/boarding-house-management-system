<?php

namespace App\Livewire\User;

use Livewire\Attributes\Layout;
use Livewire\Component;

class BoardingHouse extends Component
{

    public function mount($id)
    {
        // dd($id);
    }

    public function back()
    {
        return $this->redirect('/', navigate: true);
    }

    #[Layout('components.layouts.userAuth')]
    public function render()
    {
        return view('livewire.user.boarding-house');
    }
}
