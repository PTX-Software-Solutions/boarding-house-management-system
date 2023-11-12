<?php

namespace App\Livewire\User\Layout;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Topbar extends Component
{

    public $topBar = false;

    public function onChangeUserOption()
    {
        $this->topBar = !$this->topBar;
    }

    public function logout()
    {
        Auth::logout();

        return $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.user.layout.topbar');
    }
}
