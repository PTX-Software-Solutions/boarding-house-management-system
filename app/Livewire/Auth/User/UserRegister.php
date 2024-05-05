<?php

namespace App\Livewire\Auth\User;

use App\Enums\StatusEnums;
use App\Enums\UserTypeEnums;
use App\Livewire\Forms\User\RegistrationForm;
use App\Mail\RegisterMail;
use App\Models\Status;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserType;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class UserRegister extends Component
{
    use WithFileUploads;

    public $firstName;

    public $lastName;

    public $email;

    public $phoneNumber;

    public $userRole;

    public $termsAndCondition;

    public $password;

    public $password_confirmation;

    public $profileImage;

    public function updatedProfileImage($value)
    {
        $extension = pathinfo($value->getFilename(), PATHINFO_EXTENSION);
        if (!in_array($extension, ['png', 'jpeg', 'jpg'])) {
            $this->reset('profileImage');
        }

        $this->validate([
            'profileImage'     => 'mimes:png,jpeg,jpg|max:2048',
        ],);
    }

    public function uploadImage($image)
    {
        if ($image) {
            $randomName = Str::random(20);
            $extension = $image->getClientOriginalExtension();
            $newName = $randomName . '.' . $extension;

            // $image->storeAs('photos/client/', $newName, 's3');
            $image->storeAs('public/images', $newName);
        } else {
            // Default Image Name
            $newName = env('DEFAULT_IMAGE_NAME');
        }

        return $newName;
    }

    #[On('register-success')]
    public function home()
    {
        return $this->redirect('/login', navigate: true);
    }

    public function save()
    {
        $validated = Validator::make(
            [
                'firstName' => $this->firstName,
                'lastName'  => $this->lastName,
                'email'     => $this->email,
                'phoneNumber'     => $this->phoneNumber,
                'userRole'    => $this->userRole,
                'password'     => $this->password,
                'password_confirmation'     => $this->password_confirmation,
                'profileImage'     => $this->profileImage,
                'termsAndCondition' => $this->termsAndCondition,
            ],
            [
                'firstName' => 'required',
                'lastName'  => 'required',
                'email'     => 'required|email|unique:users',
                'phoneNumber' => ['required', 'regex:/^(09|\+639)\d{9}$/', 'unique:users,phoneNumber'],
                'userRole'    => 'required',
                'password'     => 'required|min:6',
                'password_confirmation' => 'same:password',
                'profileImage'     => 'mimes:png,jpeg,jpg|max:2048',
                'termsAndCondition' => 'accepted'
            ],
        )->validate();


        DB::beginTransaction();

        try {

            // Default registration user type
            $userDefaultType = UserType::where('serial_id', UserTypeEnums::USER)->first();
            $userDefaultStatus = Status::where('serial_id', StatusEnums::ACTIVE)->first();

            $user = User::create([
                'firstName'     => $validated['firstName'],
                'lastName'      => $validated['lastName'],
                'email'         => $validated['email'],
                'phoneNumber'   => $validated['phoneNumber'],
                'userRoleId'   => $validated['userRole'],
                'password'      => Hash::make($validated['password']),
                'userTypeId'    => $userDefaultType->id,
                'statusId'      => $userDefaultStatus->id,
                'remember_token' => Str::random(40),
                'profileImage'  => $this->uploadImage($validated['profileImage'])
            ]);

            Mail::to($validated['email'])->send(new RegisterMail($user));
            session()->flash(
                'email-verification-message',
                'Your account registered successfully and check your email for verification.'
            );
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
        return view('livewire.auth.user.user-register', [
            'user_roles' => UserRole::select('id', 'name')->get(),
        ]);
    }
}
