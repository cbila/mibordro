<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\CompanyDeleteRequest;
use App\Http\Requests\Company\CompanyIndexRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CompanyIndexRequest $request)
    {
        $perPage = $request->only('perPage') ? $request->perPage : 10;

        $companies = Company::query()->withCount('users');

        // dd($companies);

        if ($request->only(['trashed'])) {
            $companies = $companies->onlyTrashed();
        }

        return Inertia::render('Company/Index', [
            'companies'         => $companies->paginate($perPage),
            'title'             => __('app.label.company'),
            'filters'           => $request->all(['search', 'field', 'order', 'trashed']),
            'perPage'           => (int) $perPage,
            'breadcrumbs'       => [['label' => __('app.label.company'), 'href' => route('company.index')]],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $company = Company::create([
                'name'      => $request->name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'address'     => $request->address,
                'city' => $request->city,
                'contact' => $request->contact,
            ]);

            DB::commit();
            return back()->with('success', __('app.label.created_successfully', ['name' => $company->name]));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.created_error', ['name' => __('app.label.company')]) . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, Company $company)
    {
        DB::beginTransaction();
        try {
            $company->update([
                'name'      => $request->name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'address'     => $request->address,
                'city' => $request->city,
                'contact' => $request->contact,
            ]);
            DB::commit();
            return back()->with('success', __('app.label.updated_successfully', ['name' => $company->name]));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.updated_error', ['name' => $company->name]) . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyDeleteRequest $request, Company $company)
    {
        try {
            $company->delete();
            return back()->with('success', __('app.label.deleted_successfully', ['name' => $company->name]));
        } catch (\Throwable $th) {
            return back()->with('error', __('app.label.deleted_error', ['name' => $company->name]) . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        $company = Company::withTrashed()->findOrFail($id);

        try {
            $company->forceDelete();

            return back()->with('success', __('app.label.deleted_successfully', [__('app.label.company')]));
        } catch (\Throwable $th) {
            return back()->with('error', __('app.label.deleted_error', [__('app.label.company')]) . $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $company = Company::withTrashed()->findOrFail($id);

        DB::beginTransaction();
        try {
            $company->restore();

            DB::commit();
            return back()->with('success', __('app.label.updated_successfully', ['name' => $company->name]));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.updated_error', ['name' => $company->name]) . $th->getMessage());
        }
    }
}
