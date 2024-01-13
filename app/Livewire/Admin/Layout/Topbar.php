<?php

namespace App\Livewire\Admin\Layout;

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
        return $this->redirect('/admin/profile', navigate: true);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->regenerateToken();

        return $this->redirect('/admin/login');
    }

    public function render()
    {
        return view('livewire.admin.layout.topbar');
    }
}
