<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Livewire\Auth\User\UserAuth;
use App\Models\Status;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class AuthUserTest extends TestCase
{

    use RefreshDatabase, WithFaker; // Traits for testing environment and data generation

    /** @test */
    public function renders_user_login_successfully()
    {
        Livewire::test(UserAuth::class)
            ->assertStatus(200);
    }

    /** @test */
    public function component_exists_on_the_page()
    {
        $this->get('/login')
            ->assertSeeLivewire(UserAuth::class);
    }

    /** @test */
    public function successful_login()
    {
        $status = Status::factory()->create();
        $user = User::factory()->create([
            'statusId' => $status->id
        ]);

        Livewire::actingAs($user)
            ->test(UserAuth::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('login')
            ->assertStatus(200);
    }

    /** @test */
    public function invalid_email_login_fails()
    {
        $status = Status::factory()->create();
        $user = User::factory()->create([
            'statusId' => $status->id
        ]);

        Livewire::actingAs($user)
            ->test(UserAuth::class)
            ->set('email', 'invalid_email@example.com')
            ->set('password', 'password')
            ->call('login')
            ->assertStatus(200)
            ->assertSeeHtml('Invalid user', '.alert.alert-danger');
    }

    /** @test */
    public function user_is_banned_to_the_app()
    {
        $status = Status::factory(['serial_id' => 18, 'name' => 'Banned'])->create();
        $user = User::factory()->create([
            'statusId' => $status->id
        ]);

        Livewire::actingAs($user)
            ->test(UserAuth::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('login')
            ->assertStatus(200);
    }
}
