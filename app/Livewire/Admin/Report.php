<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Report extends Component
{

    public $showModal = false;

    public function handleReport(string $type)
    {
        if ($type === "reservation") {
            return $this->redirect('/admin/report/reservation', navigate: true);
        }

        // $this->toggleModal();
    }

    // public function toggleModal()
    // {
    //     $this->showModal = !$this->showModal;
    // }

    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        return view('livewire.admin.report');
    }
}
