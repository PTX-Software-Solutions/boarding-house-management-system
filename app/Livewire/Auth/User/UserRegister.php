<?php

namespace App\Livewire\Auth\User;

use App\Enums\UserTypeEnums;
use App\Livewire\Forms\User\RegistrationForm;
use App\Models\User;
use App\Models\UserType;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class UserRegister extends Component
{
    use WithFileUploads;

    #[Rule('required')]
    public $firstName;

    #[Rule('required')]
    public $lastName;

    #[Rule('required|email|unique:users')]
    public $email;

    #[Rule('required|min:6|confirmed')]
    public $password;

    #[Rule('required')]
    public $password_confirmation;

    #[Rule('nullable')]
    #[Rule(
        'mimes:png,jpg,jpeg',
        message: 'The image must be a file of type: png, jpg, jpeg with the max size of 2MB.'
    )] //2MB Image Max
    public $profileImage;

    public function updatedProfileImage($value)
    {
        $extension = pathinfo($value->getFilename(), PATHINFO_EXTENSION);
        if (!in_array($extension, ['png', 'jpeg', 'jpg', 'gif'])) {
            $this->reset('profileImage');
        }

        $this->validate([
            'profileImage' => 'mimes:png,jpeg,jpg,gif|max:2048', // .2MB Max
        ]);
    }

    public function uploadImage()
    {
        if ($this->profileImage) {
            $randomName = Str::random(20);
            $extension = $this->profileImage->getClientOriginalExtension();
            $newName = $randomName . '.' . $extension;

            $this->profileImage->storeAs('public/images', $newName);
        } else {
            // Default Image Name
            $newName = env('DEFAULT_IMAGE_NAME');
        }

        return $newName;
    }

    #[On('register-success')]
    public function home()
    {
        return $this->redirect('/', navigate: true);
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();

        try {

            // Default registration user type
            $userDefaultType = UserType::where('name', UserTypeEnums::USER)->first();

            $user = User::create([
                'firstName'     => $this->firstName,
                'lastName'      => $this->lastName,
                'email'         => $this->email,
                'password'      => Hash::make($this->password),
                'userTypeId'    => $userDefaultType->id,
                'profileImage'  => $this->uploadImage()
            ]);

            Auth::guard('web')->login($user);
            $this->dispatch('success-register');

            DB::commit();
        } catch (Exception $e) {
            Log::debug($e);
            DB::rollBack();
        }
    }

    public function login()
    {
        $this->dispatch('redirectLogin');
        return $this->redirect('/login', navigate: true);
    }

    #[Layout('components.layouts.userGuest')]
    public function render()
    {
        return view('livewire.auth.user.user-register');
    }
}
