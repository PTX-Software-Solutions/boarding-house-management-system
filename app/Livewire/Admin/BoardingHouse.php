<?php

namespace App\Livewire\Admin;

use App\Models\House;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class BoardingHouse extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $id;

    public function createBoardingHouse()
    {
        return $this->redirect('/admin/boarding-houses/create', navigate: true);
    }

    public function closeBoardingHouse()
    {
        $this->dispatch('closeBoardingHouseModal');
    }

    public function rooms($id)
    {
        return $this->redirect('/admin/boarding-houses/' . $id . '/rooms', navigate: true);
    }


    public function editBoardingHouse($id)
    {
        return $this->redirect('/admin/boarding-houses/edit/' . $id, navigate: true);
    }

    #[On('removeBH')]
    public function deleteBh($id)
    {
        House::where('id', $id)->delete();
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

    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        $boardingHouses = House::latest()->paginate(10);

        return view('livewire.admin.boarding-house', [
            'boardingHouses' => $boardingHouses
        ]);
    }
}
