<?php

namespace App\Livewire\User;

use Livewire\Attributes\Layout;
use Livewire\Component;

class AboutUs extends Component
{

    #[Layout('components.layouts.userAuth')]
    public function render()
    {
        return view('livewire.user.about-us');
    }
}
