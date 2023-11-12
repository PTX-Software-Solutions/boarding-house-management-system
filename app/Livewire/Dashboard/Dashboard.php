<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{

    #[Layout('components.layouts.userAuth')]
    public function render()
    {
        $users = User::count();

        $widget = [
            'users' => $users
        ];

        return view('livewire.dashboard.dashboard', [
            'widget' => $widget
        ]);
    }
}
