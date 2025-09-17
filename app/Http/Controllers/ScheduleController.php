<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use App\Http\Resources\RegistrationResource;
use App\Http\Resources\RunTypeResource;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\SeatResource;
use App\Models\Group;
use App\Models\Registration;
use App\Models\RunType;
use App\Models\Schedule;
use App\Models\Seat;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    use AuthorizesRequests;

    /**
     * Get Schedule Run Types
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getTypes(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $cacheKey = 'schedule-types';
        $ttl = now()->addHours(24);

        $payload = \Cache::remember($cacheKey, $ttl, function () {
            return RunType::all();
        });
        return RunTypeResource::collection($payload);
    }

    /**
     * Get all registrations for this schedule
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getRegistrations(Schedule $schedule): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->authorize('viewAnyRegistration', $schedule);
        $registrations = Registration::where('schedule_id', $schedule->id)->with(['schedule', 'user', 'character']);
        return RegistrationResource::collection($registrations);
    }

    public function getSeats(Schedule $schedule): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->authorize('viewAnySeat', $schedule);
        return SeatResource::collection($schedule->seats);
    }

    /**
     * Display all schedules
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->authorize('view', Schedule::class);
        $schedules = Schedule::where('public', true)->paginate(30);
        return ScheduleResource::collection($schedules);
    }

    /**
     * Create a new schedule
     * @throws \Throwable
     */
    public function store(ScheduleRequest $request)
    {
        $gid = $request->validated()["group_id"];
        $group = Group::findOrFail($gid);
        if(!$group->hasUser(auth()->user())) {
            return response()->unauthorized();
        }
        $schedule = new Schedule($request->validated());
        $schedule->saveOrFail();
        $schedule->refresh();

        $seat_count = $schedule->getAttribute('seat_count');
        for ($i = 0; $i < $seat_count; $i++) {
            $seat = new Seat([
                'schedule_id' => $schedule->getAttribute('id'),
                'number' => $i
            ]);
        }
        $schedule->load(['type', 'host', 'fight']);
        return ScheduleResource::make($schedule);
    }

    /**
     * Show the schedule details
     */
    public function show(Schedule $schedule): ScheduleResource
    {
        $this->authorize('show', $schedule);
        return ScheduleResource::make($schedule);
    }

    /**
     * Update the schedule's info
     */
    public function update(Request $request, Schedule $schedule): ScheduleResource
    {
        $this->authorize('update', $schedule);
        $schedule->fill($request->validated())->saveOrFail();
        return ScheduleResource::make($schedule);
    }

    /**
     * Yeet the schedule off a cliff
     */
    public function destroy(Schedule $schedule): ScheduleResource
    {
        $this->authorize('delete', $schedule);
        $schedule->delete();
        return ScheduleResource::make($schedule);
    }
}
