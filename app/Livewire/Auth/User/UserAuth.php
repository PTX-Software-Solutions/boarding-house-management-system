<?php

namespace App\Livewire\Auth\User;

use App\Livewire\User\Home;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class UserAuth extends Component
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
        return $this->redirect('/', navigate: true);
    }

    public function login()
    {
        $this->validate();

        try {
            if (Auth::guard('web')->attempt([
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

    public function register()
    {
        return $this->redirect('/register', navigate: true);
    }

    #[Layout('components.layouts.userGuest')]
    public function render()
    {
        return view('livewire.auth.user.user-auth');
    }
}
