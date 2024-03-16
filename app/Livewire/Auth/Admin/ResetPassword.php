<?php

namespace App\Livewire\Auth\Admin;

use App\Models\User;
use Error;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;

class ResetPassword extends Component
{
    #[Rule('required')]
    public $email;

    #[Rule('required')]
    public $password;

    #[Rule('required')]
    public $password_confirmation;

    #[Url(history: true)]
    public $token;

    public function handleResetPassword()
    {
        DB::beginTransaction();

        $validated = Validator::make(
            [
                'email'     => $this->email,
                'password'     => $this->password,
                'password_confirmation'     => $this->password_confirmation,
            ],
            [
                'email'     => 'required|email',
                'password'     => 'required|min:6',
                'password_confirmation' => 'same:password',
            ],
        )->validate();

        try {
            $updatePassword = DB::table('password_reset_tokens')
                ->where([
                    'email' => $validated['email'],
                    'token' => $this->token
                ])->first();

            if (!$updatePassword) {
                $this->addError('token', 'Invalid token');
                return;
            }

            User::where('email', $validated['email'])
                ->update(['password' => Hash::make($this->password)]);

            DB::table('password_reset_tokens')
                ->where([
                    'email' => $validated['email'],
                    'token' => $this->token
                ])
                ->delete();

            DB::commit();

            session()->flash('status', 'Reset password successfully.');

            $this->redirect('/admin/login');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Error($th->getMessage());
        }
    }

    #[Layout('components.layouts.adminGuest')]
    public function render()
    {
        return view('livewire.auth.admin.reset-password');
    }
}
