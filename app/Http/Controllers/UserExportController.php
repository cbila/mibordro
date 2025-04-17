<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\User\UserExportRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-user', ['only' => ['create']]);
    }


    public function create(UserExportRequest $request)
    {
        $writer = [
            'xlsx'  => \Maatwebsite\Excel\Excel::XLSX,
            'xls'   => \Maatwebsite\Excel\Excel::XLS,
            'ods'   => \Maatwebsite\Excel\Excel::ODS,
            'csv'   => \Maatwebsite\Excel\Excel::CSV,
            'html'  => \Maatwebsite\Excel\Excel::HTML,
            'pdf'   => \Maatwebsite\Excel\Excel::MPDF,
        ];

        $users = User::with(['roles:id,name', 'company:id,name', 'sgk:id,name'])
            ->whereIn('id', $request->selectedId)->get();

        activity()
        ->causedBy(auth()->id())
        ->event('exported')
        ->withProperties(['users' => $users->pluck('id')])
        ->log('export');

        return (new UsersExport($users))
            ->download('Mibordro kullanıcı'.'.'.$request->selectedWriter, $writer[$request->selectedWriter]);
    }
}
