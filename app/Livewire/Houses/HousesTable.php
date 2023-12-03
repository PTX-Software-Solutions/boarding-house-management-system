<?php

namespace App\Livewire\Houses;

use App\Models\House;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class HousesTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $id;

    public function createBoardingHouse()
    {
        // $this->dispatch('resetInputFields');
        // $this->dispatch('openBoardingHouseModal');
        // $this->dispatch('mapSize');
        return $this->redirect('/boarding-house/create', navigate: true);
    }

    public function closeBoardingHouse()
    {
        $this->dispatch('closeBoardingHouseModal');
    }


    public function editBoardingHouse($id)
    {
        return $this->redirect('/boarding-house/edit/'. $id, navigate: true);
        // $this->dispatch('editBoardingHouse', $id);
        // $this->dispatch('mapSize');
    }

    #[On('removeBH')]
    public function deleteBh($id)
    {
        House::where('id', $id)->delete();
        // $this->id = $id;
        // dd($this->id);
    }

    public function deleteBoardingHouse($id)
    {
        $this->dispatch('deleteBH', id: $id);
    }

    #[On('goOn-Delete')]
    public function delete($id)
    {
        House::where('id', $id)->delete();
    }

    #[Layout('components.layouts.userAuth')]
    public function render()
    {
        $boardingHouses = House::latest()->paginate(10);

        return view('livewire.houses.houses-table', [
            'boardingHouses' => $boardingHouses
        ]);
    }
}
