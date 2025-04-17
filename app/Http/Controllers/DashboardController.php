<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Category;
use App\Models\Company;
use App\Models\Document;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Sgk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function show(Request $request)
    {
        $user_count = User::count() - 1;
        $trashed_count = User::onlyTrashed()->count();
        $company_count = Company::count();
        $role_count = Role::count();
        $permission_count = Permission::count();
        $document_count = Document::count();
        $activity_count = Activity::count();
        $sgk_count = Sgk::count();

        // $counts = DB::select("SELECT (SELECT COUNT(*) FROM users) as user_count, 
        //                 (SELECT COUNT(*) FROM companies) as company_count, 
        //                 (SELECT COUNT(*) FROM roles) as role_count
        //                 (SELECT COUNT(*) FROM permissions) as permission_count,
        //                 (SELECT COUNT(*) FROM documents) as document_count,
        //                 (SELECT COUNT(*) FROM acitivities) as activity_count),
        //                 (SELECT COUNT(*) FROM sgks) as sgk_count");

        // dd($counts);

        $categories = Category::all(['id', 'name']);


        return Inertia::render('Dashboard', [
            'title'             => __('app.label.dashboard'),
            'breadcrumbs'       => [[ 'href' => route('dashboard')]],
            'user_count'        => $user_count,
            'trashed_count'     => $trashed_count,
            'company_count'     => $company_count,
            'role_count'        => $role_count,
            'permission_count'  => $permission_count,
            'activity_count'    => $activity_count,
            'document_count'    => $document_count,
            'sgk_count'         => $sgk_count,
            'categories'        => $categories,
            'user'              => $request->user()
        ]);
    }
}
