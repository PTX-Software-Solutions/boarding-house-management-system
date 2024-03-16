<?php

namespace App\Livewire\Auth\Management;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ManagementLogin extends Component
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
        return $this->redirect('/management/dashboard', navigate: true);
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

            // Check user TYPE: MANAGEMENT
            if (!$user->isManagement()) {
                $this->addError('login', 'Unauthorized user');
                return;
            }

            if (Auth::guard('management')->attempt([
                'email' => $this->email,
                'password' => $this->password
            ], $this->rememberMe)) {
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
        return $this->redirect('/management/forgot-password', navigate: true);
    }


    #[Layout('components.layouts.managementGuest')]
    public function render()
    {
        return view('livewire.auth.management.management-login');
    }
}
