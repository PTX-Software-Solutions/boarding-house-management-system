<?php

namespace App\Livewire\User\Layout;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function profile()
    {
        return $this->redirect('/profile', navigate: true);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->regenerateToken();
        return $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.user.layout.topbar');
    }
}
