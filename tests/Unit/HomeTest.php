<?php


namespace Tests\Unit\Livewire\User;

use App\Livewire\User\Home;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\House;
use App\Models\Status;
use App\Models\User;
use Livewire\Livewire;

class HomeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function initial_render_shows_empty_results()
    {
        Livewire::test(Home::class)
            ->assertSee('PLEASE SEARCH YOUR LOCATION');
    }

    /** @test */
    public function search_term_updates_map_data()
    {

        // Create a dummy status for testing
        $status = Status::factory()->create();
        // Create a dummy user for testing
        $user = User::factory([
            'statusId' => $status->id
        ])->create();
        // Create a dummy house for testing
        House::factory([
            'userId' => $user->id
        ])->create();

        $searchTerm = 'Dumaguete';

        Livewire::test(Home::class)
            ->set('search', $searchTerm)
            ->call('filterSearch')
            ->assertSee('locations');
    }

    /** @test */
    public function empty_search_term_clears_results()
    {
        // Simulate previous search
        Livewire::test(Home::class)
            ->set('search', 'Dumaguete')
            ->call('filterSearch');

        // Perform empty search
        Livewire::test(Home::class)
            ->set('search', '')
            ->call('filterSearch')
            ->assertSee('locations');
    }
}
