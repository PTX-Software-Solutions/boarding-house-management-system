<?php

namespace App\Livewire\Admin;

use App\Enums\StatusEnums;
use App\Models\Status;
use App\Models\User;
use App\Models\UserType;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule as LaravelRule;

class UserForm extends Component
{
    use WithFileUploads;

    public $currentTab = 1;

    public $id;

    // #[Rule('required', message: 'The user type is required')]
    public $userTypeId;

    // #[Rule('required', message: 'The status is required')]
    public $statusId;

    // #[Rule('required')]
    public $firstName;

    // #[Rule('required')]
    public $lastName;

    // #[Rule('required|email|unique:users', onUpdate: false)]
    public $email;

    // #[Rule('required|min:6')]
    public $currentPassword;

    // #[Rule('required|min:6')]
    public $password;

    // #[Rule('required|same:password')]
    public $password_confirmation;

    // #[Rule('mimes:png,jpeg,jpg|max:2048')]
    public $profileImage;

    public $oldImage;

    public function back()
    {
        return $this->redirect('/admin/users', navigate: true);
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->edit($id);
        }
    }

    public function edit($id)
    {
        $this->id = $id;
        $user = User::findOrFail($id);

        $this->firstName = $user->firstName;
        $this->lastName = $user->lastName;
        $this->email = $user->email;
        $this->userTypeId = $user->userTypeId;
        $this->statusId = $user->statusId;
        $this->oldImage = $user->profileImage;
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

            if ($this->id) {

                $user = User::findOrFail($this->id);

                // dd($validated);

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
            }

            return $this->redirect('/admin/users', navigate: true);
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug($e);
        }
    }

    public function save()
    {
        if ($this->id) {
            $validated = Validator::make(
                [
                    'userTypeId' => $this->userTypeId,
                    'statusId'  => $this->statusId,
                    'firstName' => $this->firstName,
                    'lastName'  => $this->lastName,
                    'email'     => $this->email,
                    'profileImage'     => $this->profileImage,
                ],
                [
                    'userTypeId' => 'required',
                    'statusId'  => 'required',
                    'firstName' => 'required',
                    'lastName'  => 'required',
                    'email'     => ['required', 'email', LaravelRule::unique('users')->ignore($this->id)],
                    // 'password'     => 'required|min:6',
                    // 'password_confirmation' => 'required|same:password',
                    'profileImage'     => 'nullable|mimes:png,jpeg,jpg|max:2048',
                ],
                [
                    'userTypeId.required' => 'The user type is required',
                    'statusId.required' => 'The status is required'
                ]
            )->validate();
        } else {
            $validated = Validator::make(
                [
                    'userTypeId' => $this->userTypeId,
                    'statusId'  => $this->statusId,
                    'firstName' => $this->firstName,
                    'lastName'  => $this->lastName,
                    'email'     => $this->email,
                    'password'     => $this->password,
                    'password_confirmation'     => $this->password_confirmation,
                    'profileImage'     => $this->profileImage,
                ],
                [
                    'userTypeId' => 'required',
                    'statusId'  => 'required',
                    'firstName' => 'required',
                    'lastName'  => 'required',
                    // 'email'     => 'required|email|unique:users',
                    'email'     => ['required', 'email', LaravelRule::unique('users')->ignore($this->id)],
                    'password'     => 'required|min:6',
                    'password_confirmation' => 'required|same:password',
                    'profileImage'     => 'mimes:png,jpeg,jpg|max:2048',
                ],
                [
                    'userTypeId.required' => 'The user type is required',
                    'statusId.required' => 'The status is required'
                ]
            )->validate();
        }

        try {

            DB::beginTransaction();


            if ($this->id) {


                $user = User::findOrFail($this->id);

                if ($this->profileImage) {
                    $data = [
                        'firstName'     => $validated['firstName'],
                        'lastName'      => $validated['lastName'],
                        'email'         => $validated['email'],
                        'profileImage'  => $this->uploadImage($validated['profileImage']),
                        'userTypeId'    => $validated['userTypeId'],
                        'statusId'      => $validated['statusId']
                    ];
                } else {
                    $data = [
                        'firstName'     => $validated['firstName'],
                        'lastName'      => $validated['lastName'],
                        'email'         => $validated['email'],
                        'userTypeId'    => $validated['userTypeId'],
                        'statusId'      => $validated['statusId']
                    ];
                }

                $user->update($data);

                DB::commit();
                $this->dispatch('success-update');
            } else {

                User::create([
                    'firstName'     => $validated['firstName'],
                    'lastName'      => $validated['lastName'],
                    'email'         => $validated['email'],
                    'password'      => Hash::make($validated['password']),
                    'profileImage'  => $this->uploadImage($validated['profileImage']),
                    'userTypeId'    => $validated['userTypeId'],
                    'statusId'      => $validated['statusId']
                ]);

                DB::commit();
                $this->dispatch('success-insert');
            }

            return $this->redirect('/admin/users', navigate: true);
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug($e);
        }
    }

    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        $userTypes = UserType::select('id', 'name')->get();
        $userStatuses = Status::select('id', 'name')
            ->whereIn('serial_id', [StatusEnums::ACTIVE, StatusEnums::INACTIVE, StatusEnums::BANNED])
            ->get();

        return view('livewire.admin.user-form', [
            'userTypes' => $userTypes,
            'userStatuses' => $userStatuses
        ]);
    }
}
