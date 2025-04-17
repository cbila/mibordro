<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileReadRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Document;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Profile::class, 'profile');
    }
    /**
     * Display the user's profile form.
     */
    public function show(Profile $profile): Response
    {
        return Inertia::render('Profile/Show', [
            // 'profile'           => $profile,
            // 'documents'         => Document::where('user_id', $profile->id)->latest()->paginate(),
            'mustVerifyEmail'   => request()->user() instanceof MustVerifyEmail,
            'status'            => session('status'),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(ProfileUpdateRequest $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);

    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if (! $request->user()->isDirty('email')) {
            return Redirect::back()->with('warning', 'E-postanızda bir değişiklik yok!');
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // dd($request->user()->name);

        return Redirect::back()->with('success', 'E-postanız başarıyla değiştirildi');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the user's profile form.
     */
    public function documents(Profile $profile): Response
    {
        return Inertia::render('Profile/Documents', [
            'documents'         => Document::where('user_id', $profile->id)->latest()->paginate(),
            'mustVerifyEmail'   => request()->user() instanceof MustVerifyEmail,
            'status'            => session('status'),
        ]);
    }
}
