<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserExcelExport implements FromView
{
    public function view(): View
    {
        $users = User::with('status', 'userType')->orderBy('created_at', 'DESC')->get();

        return view('exports.users', [
            'users' => $users
        ]);
    }
}
