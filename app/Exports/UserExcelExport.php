<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserExcelExport implements FromView
{

    public $search;

    public function __construct($search)
    {
        $this->search = $search;
    }

    public function view(): View
    {
        $users = User::with('status', 'userType')
            ->orderBy('created_at', 'DESC')
            ->when($this->search, function ($query) {
                $query->where('firstName', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('lastName', 'LIKE', '%' . $this->search . '%');
            })
            ->get();

        return view('exports.users', [
            'users' => $users
        ]);
    }
}
