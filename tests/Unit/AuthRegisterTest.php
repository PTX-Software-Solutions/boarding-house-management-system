<?php

namespace Tests\Unit;

use App\Enums\StatusEnums;
use App\Enums\UserTypeEnums;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Livewire\Auth\User\UserAuth;
use App\Livewire\Auth\User\UserRegister;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class AuthRegisterTest extends TestCase
{

    use RefreshDatabase, WithFaker; // Traits for testing environment and data generation

    /** @test */
    public function renders_user_login_successfully()
    {
        Livewire::test(UserRegister::class)
            ->assertSee('Register');
    }

    /** @test */
    public function test_successful_user_registration()
    {
        $userData = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phoneNumber' => $this->faker->phoneNumber,
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ];

        Livewire::test(UserRegister::class)
            ->set('firstName', $userData['firstName'])
            ->set('lastName', $userData['lastName'])
            ->set('email', $userData['email'])
            ->set('phoneNumber', $userData['phoneNumber'])
            ->set('password', $userData['password'])
            ->set('password_confirmation', $userData['password_confirmation'])
            ->call('save')
            ->assertStatus(200);
    }
}
