<?php

namespace App\Livewire\User;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Home extends Component
{
    public $longitude = 123.31; // default longitude of dumaguete city
    public $latitude = 9.31;    // default latitude of dumaguete city

    #[Layout('components.layouts.userAuth')]
    public function render()
    {
        return view('livewire.user.home');
    }
}
