<?php

namespace App\Livewire\Admin;

use App\Exports\UserExcelExport;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Livewire\Attributes\Url;

class Users extends Component
{

    #[Url(history: true)]
    public $search;

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
        return Excel::download(new UserExcelExport($this->search), 'users' . Carbon::now()->format('YmdHis') . '.xlsx');
    }

    public function exportPdfBoardingHouse(Request $request)
    {
        $search = $request->query('search') ?? false;

        $users = User::with('status', 'userType')
            ->orderBy('created_at', 'DESC')
            ->when($search, function ($query) use($search) {
                $query->where('firstName', 'LIKE', '%' . $search . '%')
                    ->orWhere('lastName', 'LIKE', '%' . $search . '%');
            })
            ->get()
            ->toArray();

        $pdf = PDF::loadView('pdf.users', ['users' => $users]);
        return $pdf->download('users' . Carbon::now()->format('YmdHis') . '.pdf');
    }

    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        $users = User::with('status', 'userType')
            ->orderBy('created_at', 'DESC')
            ->when($this->search, function ($query) {
                $query->where('firstName', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('lastName', 'LIKE', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.admin.users', [
            'users' => $users
        ]);
    }
}
