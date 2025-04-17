<?php

namespace App\Http\Controllers;

use App\Models\Sgk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SGKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->only('perPage') ? $request->perPage : 10;

        $sgk = Sgk::query();

        if ($request->only(['trashed'])) {
            $sgk = $sgk->onlyTrashed();
        }

        return Inertia::render('SGK/Index', [
            'sgks'              => $sgk->paginate($perPage),
            'title'             => __('app.label.sgk'),
            'filters'           => $request->all(['search', 'field', 'order', 'trashed']),
            'perPage'           => (int) $perPage,
            'breadcrumbs'       => [['label' => __('app.label.sgk'), 'href' => route('sgk.index')]],
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $sgk = SGK::create([
                'name'      => $request->name,
                'address'     => $request->address,
                'city' => $request->city,
            ]);

            DB::commit();
            return back()->with('success', __('app.label.created_successfully', ['name' => $sgk->name]));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.created_error', ['name' => __('app.label.company')]) . $th->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sgk $sgk)
    {
        // dd($request->address);
        DB::beginTransaction();
        try {
            $sgk->update([
                'name'      => $request->name,
                'address'     => $request->address,
                'city' => $request->city,
            ]);
            DB::commit();
            return back()->with('success', __('app.label.updated_successfully', ['name' => $sgk->name]));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.updated_error', ['name' => $sgk->name]) . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, SGK $sgk)
    {
        try {
            $sgk->delete();
            return back()->with('success', __('app.label.deleted_successfully', ['name' => $sgk->name]));
        } catch (\Throwable $th) {
            return back()->with('error', __('app.label.deleted_error', ['name' => $sgk->name]) . $th->getMessage());
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
        $sgk = SGK::withTrashed()->findOrFail($id);

        try {
            $sgk->forceDelete();

            return back()->with('success', __('app.label.deleted_successfully', [__('app.label.sgk')]));
        } catch (\Throwable $th) {
            return back()->with('error', __('app.label.deleted_error', [__('app.label.sgk')]) . $th->getMessage());
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
        $sgk = SGK::withTrashed()->findOrFail($id);
        // dd($user);


        DB::beginTransaction();
        try {
            // dd($user);
            $sgk->restore();


            DB::commit();
            return back()->with('success', __('app.label.updated_successfully', ['name' => $sgk->name]));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.updated_error', ['name' => $sgk->name]) . $th->getMessage());
        }
    }


}
