<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;

class ReportReservation extends Component
{
    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        return view('livewire.admin.report-reservation');
    }
}
