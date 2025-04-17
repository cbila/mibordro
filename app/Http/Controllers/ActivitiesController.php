<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Activity;
use App\Models\User;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->only('perPage') ? $request->perPage : 100;

        $causers = User::whereIn('id', Activity::pluck('causer_id'))->get(['id', 'name']);
        $events = Activity::whereNotNull('event')->select('event')->distinct()->get()->pluck(['event']);

        $selectedCauser = $request->query('selectedCauser');
        $selectedEvent = $request->query('selectedEvent');

        $activities = Activity::query();

        if ($selectedCauser) {
            $activities->where('causer_id', $selectedCauser['id']);
        };

        if ($selectedEvent) {
            $activities->where('event', $selectedEvent);
        };

        $count = $activities->count();

        return Inertia::render('Activities/Index', [
            'title'             => __('app.label.logs'),
            'filters'           => $request->only(['page', 'perPage', 'selectedCauser']),
            'perPage'           => (int)$perPage,
            'activities'        => $activities->latest()->paginate($perPage)->withQueryString(),
            'causers'           => $causers,
            'events'            => $events,
            'count'             => $count,
            'breadcrumbs'       => [['label' => __('app.label.logs'), 'href' => route('activities.index')]],
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function activities(Request $request, User $user)
    {
        $perPage = $request->only('perPage') ? $request->perPage : 100;

        return Inertia::render('User/Activities', [
            'title'             => __('app.label.logs'),
            'filters'           => $request->only(['page', 'perPage', 'selectedCauser']),
            'perPage'           => (int)$perPage,
            'activities'        => Activity::where('causer_id', $user->id)->latest()->paginate($perPage)->withQueryString(),
            'user'              => $user,
            'breadcrumbs'       => [['label' => __('app.label.logs'), 'href' => route('activities.index')]],
        ]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $activity = Activity::findOrFail($id);

        try {
            $activity->forceDelete();

            return back()->with('success', __('app.label.deleted_successfully', [__('app.label.user')]));
        } catch (\Throwable $th) {
            return back()->with('error', __('app.label.deleted_error', [__('app.label.user')]) . $th->getMessage());
        }
    }


}
