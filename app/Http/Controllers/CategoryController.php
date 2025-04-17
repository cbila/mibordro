<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryIndexRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryIndexRequest $request)
    {
        $perPage = $request->only('perPage') ? $request->perPage : 10;

        $categories = Category::query();

        if ($request->only(['trashed'])) {
            $categories = $categories->onlyTrashed();
        }

        return Inertia::render('Category/Index', [
            'title'             => __('app.label.category'),
            'filters'           => $request->all(['search', 'field', 'order', 'trashed']),
            'categories'        => $categories->paginate($perPage),
            'breadcrumbs'       => [['label' => __('app.label.category'), 'href' => route('category.index')]],
            'perPage'           => (int) $perPage,
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
            $category = Category::create([
                'name'      => $request->name,
            ]);

            DB::commit();
            return back()->with('success', __('app.label.created_successfully', ['name' => $category->name]));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.created_error', ['name' => __('app.label.category')]) . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        DB::beginTransaction();
        try {
            $category->update([
                'name'      => $request->name,
            ]);
            DB::commit();
            return back()->with('success', __('app.label.updated_successfully', ['name' => $category->name]));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.updated_error', ['name' => $category->name]) . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return back()->with('success', __('app.label.deleted_successfully', ['name' => $category->name]));
        } catch (\Throwable $th) {
            return back()->with('error', __('app.label.deleted_error', ['name' => $category->name]) . $th->getMessage());
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
        $category = Category::withTrashed()->findOrFail($id);

        try {
            $category->forceDelete();

            return back()->with('success', __('app.label.deleted_successfully', [__('app.label.category')]));
        } catch (\Throwable $th) {
            return back()->with('error', __('app.label.deleted_error', [__('app.label.category')]) . $th->getMessage());
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
        $category = Category::withTrashed()->findOrFail($id);

        DB::beginTransaction();
        try {
            $category->restore();
            DB::commit();
            return back()->with('success', __('app.label.updated_successfully', ['name' => $category->name]));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.updated_error', ['name' => $category->name]) . $th->getMessage());
        }
    }
}
