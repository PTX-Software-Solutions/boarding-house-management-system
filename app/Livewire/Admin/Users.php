<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Users extends Component
{

    public function editUser($id)
    {
        return $this->redirect('/admin/users/edit/' . $id, navigate: true);
    }

    public function createUser()
    {
        return $this->redirect('/admin/users/create', navigate: true);
    }

    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        $users = User::with('status', 'userType')->orderBy('created_at', 'DESC')->paginate(10);

        return view('livewire.admin.users', [
            'users' => $users
        ]);
    }
}
