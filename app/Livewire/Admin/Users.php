<?php

namespace App\Livewire\Admin;

use App\Exports\UserExcelExport;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class Users extends Component
{

    public function editUser($id)
    {
        return $this->redirect('/admin/users/edit/' . $id, navigate: true);
    }

    public function createUser()
    {
        return $this->redirect('/admin/users/create', navigate: true);
    }

    public function exportExcelUsers()
    {
        return Excel::download(new UserExcelExport, 'users' . Carbon::now()->format('YmdHis') . '.xlsx');
    }

    public function exportPdfBoardingHouse()
    {
        $users = User::with('status', 'userType')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->toArray();

        $pdf = PDF::loadView('pdf.users', ['users' => $users]);
        return $pdf->download('users' . Carbon::now()->format('YmdHis') . '.pdf');
    }

    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        $users = User::with('status', 'userType')->orderBy('created_at', 'DESC')->paginate(10);

        return view('livewire.admin.users', [
            'users' => $users
        ]);
    }
}
