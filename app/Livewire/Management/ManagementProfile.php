<?php

namespace App\Livewire\Management;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

class ManagementProfile extends Component
{
    use WithFileUploads;

    public $profileImage;

    public $oldImage;

    public $firstName;

    public $lastName;

    public $email;

    public $currentPassword;

    public $password;

    public $password_confirmation;

    public function mount()
    {
        $user = User::findOrFail(Auth::guard('management')->user()->id);
        $this->firstName = $user->firstName;
        $this->lastName = $user->lastName;
        $this->email = $user->email;
        $this->oldImage = $user->profileImage;
    }

    public function save()
    {
        $validated = Validator::make(
            [
                'firstName' => $this->firstName,
                'lastName'  => $this->lastName,
                'email'     => $this->email,
                'profileImage'     => $this->profileImage,
            ],
            [
                'firstName' => 'required',
                'lastName'  => 'required',
                'email'     => ['required', 'email', Rule::unique('users')->ignore(Auth::guard('management')->user()->id)],
                'profileImage'     => 'nullable|mimes:png,jpeg,jpg|max:2048',
            ],
        )->validate();

        try {

            DB::beginTransaction();

            $user = User::findOrFail(Auth::guard('management')->user()->id);

            if ($this->profileImage) {
                $data = [
                    'firstName'     => $validated['firstName'],
                    'lastName'      => $validated['lastName'],
                    'email'         => $validated['email'],
                    'profileImage'  => $this->uploadImage($validated['profileImage']),
                ];
            } else {
                $data = [
                    'firstName'     => $validated['firstName'],
                    'lastName'      => $validated['lastName'],
                    'email'         => $validated['email'],
                ];
            }

            $user->update($data);

            DB::commit();
            $this->dispatch('success-update');

            return $this->redirect('/management/profile', navigate: true);
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug($e);
        }
    }

    public function updatePassword()
    {
        $validated = Validator::make(
            [
                'currentPassword' => $this->currentPassword,
                'password'     => $this->password,
                'password_confirmation'     => $this->password_confirmation
            ],
            [
                'currentPassword' => 'required',
                'password'     => 'required|min:6',
                'password_confirmation' => 'required|same:password',
            ]
        )->validate();

        try {

            DB::beginTransaction();

            $user = User::findOrFail(Auth::guard('management')->user()->id);

            // Check the currentPassword
            $isCorrectPassword = Hash::check($this->currentPassword, $user->password);

            if (!$isCorrectPassword) {
                $this->addError('currentPassword', 'Incorrect password');
                return;
            }

            $user->update([
                'password' => Hash::make($validated['password'])
            ]);

            DB::commit();
            $this->dispatch('success-update');

            return $this->redirect('/management/profile', navigate: true);
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug($e);
        }
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

    #[Layout('components.layouts.managementAuth')]
    public function render()
    {
        return view('livewire.management.management-profile');
    }
}
