<?php

namespace App\Livewire\Auth\Admin;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class AdminLogin extends Component
{
    #[Rule('required')]
    public $email;

    #[Rule('required')]
    public $password;

    #[Rule('nullable')]
    public $rememberMe;

    #[On('login-success')]
    public function home()
    {
        return $this->redirect('/admin/dashboard', navigate: true);
    }

    public function login()
    {
        $this->validate();
        try {
            $user = User::where('email', $this->email)->first();

            // Check user does exists
            if (is_null($user)) {
                $this->addError('login', 'Invalid user');
                return;
            }

            // Check user TYPE: ADMIN
            if (!$user->isAdmin()) {
                $this->addError('login', 'Unauthorized user');
                return;
            }

            if (Auth::guard('admin')->attempt([
                'email' => $this->email,
                'password' => $this->password
            ], $this->rememberMe)) {
                Auth::guard('admin')->login($user);
                $this->dispatch('success-login');
            } else {
                $this->addError('login', 'Incorrect email or password');
            }
        } catch (Exception $e) {
            Log::debug($e);
        }
    }

    public function forgotPassword()
    {
        return $this->redirect('/admin/forgot-password', navigate: true);
    }

    #[Layout('components.layouts.adminGuest')]
    public function render()
    {
        return view('livewire.auth.admin.admin-login');
    }
}
