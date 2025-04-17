<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Http\Requests\User\UserDeleteRequest;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\User\UserShowRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Role;
use App\Models\Sgk;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-user', ['only' => ['create', 'store']]);
        $this->middleware('permission:view-user', ['only' => ['index']]);
        $this->middleware('permission:update-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy', 'destroyBulk', 'forceDelete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserIndexRequest $request)
    {
        $users = User::with(['roles:id,name', 'company:id,name', 'sgk:id,name'])
            ->whereHas('roles', function ($query) {
                return $query->where('name', '!=', 'superadmin');
            });

        $users->filter($request->only('search'));

        $users->filter($request->only('company'));

        if ($request->only(['field', 'order'])) {
            $users->order($request->only(['field', 'order']));
        }

        if ($request->only(['trashed'])) {
            $users = $users->onlyTrashed();
        }

        $count = $users->count();

        $perPage = $request->only('perPage') ? $request->perPage : 25;
        $roles = Role::where('name', '!=', 'superadmin')->get(['id', 'name']);
        $companies = Company::all(['id', 'name']);
        $categories = Category::all(['id', 'name']);
        $sgks = Sgk::all(['id', 'name']);
        $company = $request->only('company');


        return Inertia::render('User/Index', [
            'title'             => __('app.label.user'),
            'mustVerifyEmail'   => request()->user() instanceof MustVerifyEmail,
            'status'            => session('status'),
            'filters'           => $request->only(['search', 'company','field', 'order', 'page', 'perPage', 'trashed']),
            'perPage'           => (int)$perPage,
            'users'             => $users->paginate($perPage)->withQueryString(),
            'roles'             => $roles,
            'companies'         => $companies,
            'company'           => $company,
            'categories'        => $categories,
            'sgks'              => $sgks,
            'count'             => $count,
            'breadcrumbs'       => [['label' => __('app.label.user'), 'href' => route('users.index')]],
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $password = Str::password(10);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'identity' => $request->identity,
                'company_id' => $request->company['id'],
                'sgk_id' => $request->sgk['id'],
                'recruitment_date' => $request->recruitment_date,
                'gsm' => $request->gsm,
                'iban' => $request->iban,
                'position' => $request->position,
                'holidays' => $request->holidays,
                'info' => $request->info,
            ]);

            $user->syncRoles($request->roles);

            DB::commit();

            UserCreated::dispatch($user, $password);

            return back()->with('success', __('app.label.created_successfully', ['name' => $user->name]));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.created_error', ['name' => __('app.label.user')]) . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UserShowRequest $request)
    {
        $user = User::findOrFail($request->user)->load(['roles:id,name', 'company:id,name', 'sgk:id,name']);

        $lastLogin = $request->user()->activities->where('event', 'login')->last();

        if ($lastLogin) {
            $lastLogin = $lastLogin->created_at->format('d-m-Y H:i');
        } else {
            $lastLogin = '';
        }

        $roles = Role::where('name', '!==', 'superadmin')->get(['id', 'name']);
        $companies = Company::all(['id', 'name']);
        $categories = Category::all(['id', 'name']);
        $sgks = Sgk::all(['id', 'name']);

        return Inertia::render('User/Show', [
            'title'             => __('app.label.edit'),
            'mustVerifyEmail'   => request()->user() instanceof MustVerifyEmail,
            'status'            => session('status'),
            'filters'           => $request->all(['search', 'field', 'order']),
            'user'              => $user,
            'roles'             => $roles,
            'companies'         => $companies,
            'categories'        => $categories,
            'sgks'              => $sgks,
            'lastLogin'         => $lastLogin,
            'breadcrumbs'       => [['label' => __('app.label.profile'), 'href' => route('users.show', $user->id)]],
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            $user->update([
                'name'              => $request->name,
                'email'             => $request->email,
                'password'          => $request->password ? Hash::make($request->password) : $user->password,
                'identity'          => $request->identity,
                'company_id'        => $request->company['id'],
                'sgk_id'            => $request->sgk['id'],
                'recruitment_date'  => $request->recruitment_date,
                'gsm'               => $request->gsm,
                'iban'              => $request->iban,
                'position'          => $request->position,
                'holidays'          => $request->holidays,
                'info'              => $request->info,
                'roles'             => $request->roles
            ]);

            $user->syncRoles($request->roles);
            DB::commit();
            return back()->with('success', __('app.label.updated_successfully', ['name' => $user->name]));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.updated_error', ['name' => $user->name]) . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserDeleteRequest $request, User $user)
    {
        try {
            $user->delete();

            return back()->with('success', __('app.label.deleted_successfully', ['name' => $user->name]));
        } catch (\Throwable $th) {
            return back()->with('error', __('app.label.deleted_error', ['name' => $user->name]) . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(UserDeleteRequest $request, $user)
    {
        $user = User::onlyTrashed()->findOrFail($user);

        $disk = Storage::disk('do');
        $documents = $user->documents()->get();

        try {
            foreach ($documents as $document) {
                $disk->delete($document->file);
                $document->delete();
            }

            $user->forceDelete();

            return back()->with('success', __('app.label.deleted_successfully', [__('app.label.user')]));
        } catch (\Throwable $th) {
            return back()->with('error', __('app.label.deleted_error', [__('app.label.user')]) . $th->getMessage());
        }
    }

    public function destroyBulk(UserDeleteRequest $request)
    {
        try {
            $user = User::whereIn('id', $request->id);
            $user->delete();
            return back()->with('success', __('app.label.deleted_successfully', ['name' => count($request->id) . ' ' . __('app.label.user')]));
        } catch (\Throwable $th) {
            return back()->with('error', __('app.label.deleted_error', ['name' => count($request->id) . ' ' . __('app.label.user')]) . $th->getMessage());
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
        $user = User::withTrashed()->findOrFail($id);


        DB::beginTransaction();
        try {
            $user->restore();

            DB::commit();
            return back()->with('success', __('app.label.updated_successfully', ['name' => $user->name]));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.updated_error', ['name' => $user->name]) . $th->getMessage());
        }
    }


}
