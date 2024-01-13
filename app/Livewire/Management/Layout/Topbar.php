<?php

namespace App\Livewire\Management\Layout;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Topbar extends Component
{
    public $topBar = false;

    public function onChangeUserOption()
    {
        $this->topBar = !$this->topBar;
    }

    public function profile()
    {
        return $this->redirect('/management/profile', navigate: true);
    }


    public function logout(Request $request)
    {
        Auth::guard('management')->logout();
        $request->session()->regenerateToken();

        return $this->redirect('/management/login');
    }

    public function render()
    {
        return view('livewire.management.layout.topbar');
    }
}
