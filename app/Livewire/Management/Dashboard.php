<?php

namespace App\Livewire\Management;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    #[Layout('components.layouts.managementAuth')]
    public function render()
    {
        $users = User::count();

        $widget = [
            'users' => $users
        ];

        return view('livewire.management.dashboard', [
            'widget' => $widget
        ]);
    }
}
