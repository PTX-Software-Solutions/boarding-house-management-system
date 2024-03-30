<?php

namespace App\Livewire\Auth\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;

class EmailVerification extends Component
{

    public function verify(Request $request)
    {
        $user = User::where('remember_token', $request->query('token'))->firstOrFail();
        if ($user) {
            $user->email_verified_at = now();
            $user->remember_token = Str::random(40);
            $user->save();
            Auth::guard('web')->login($user);
        }
        return redirect('/')->with('status', 'Welcome to the BH Locator!');
    }

    #[Layout('components.layouts.userGuest')]
    public function render()
    {
        return view('livewire.auth.user.email-verification');
    }
}
