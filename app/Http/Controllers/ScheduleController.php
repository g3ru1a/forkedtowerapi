<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use App\Http\Resources\RegistrationResource;
use App\Http\Resources\RunTypeResource;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\ScheduleSummary;
use App\Http\Resources\SeatResource;
use App\Models\Group;
use App\Models\Registration;
use App\Models\RunType;
use App\Models\Schedule;
use App\Models\Seat;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
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
     * Display all schedules made by the group
     */
    public function groupSchedules(Group $group): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->authorize('viewSchedules', $group);
        $schedules = $group->schedules()
            ->with(['type', 'host', 'fight', 'seats'])
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->limit(50)
            ->get();
        return ScheduleResource::collection($schedules);
    }

    public function canRegister(Schedule $schedule, ?string $secret = null): ScheduleResource | JsonResponse {
        $passed = false;
        if($schedule->public) $passed = true;
        else if($schedule->private_key === $secret) $passed = true;
        if(!$passed) return response()->json(['message' => 'Unauthorized'], 403);

        $sch = Schedule::where('id', $schedule->id)
            ->withCount([
                'registrations as recruiting_count' => fn($q) => $q->where('status', 'pending'),
                'seats as filled_count' => fn($q) => $q->whereNotNull('character_id'),
            ])
            ->with(['type', 'group', 'host', 'fight', 'seats.ffclass', 'seats.phantom_job'])
            ->first();
        return ScheduleResource::make($sch);
    }

    /**
     * Display a info summary of the groups schedules
     */
    public function groupSchedulesSummary(Group $group): ScheduleSummary
    {
        $this->authorize('viewSchedules', $group);
        $group = Group::withCount([
            'schedules as total',
            'schedules as recruiting_count' => function ($query) {
                $query->whereHas('registrations', function ($q) {
                    $q->where('status', 'pending');
                });
            },
            'schedules as active_schedules_count' => fn($q) => $q->where('status', '!=', 'finished'),
        ])->find($group->id);
        return ScheduleSummary::make($group);
    }

    /**
     * Get the groups upcomming schedule
     */
    public function groupSchedulesNext(Group $group): ScheduleResource
    {
        $this->authorize('viewSchedules', $group);
        $schedules = $group->schedules()
            ->whereRaw("(date + time) > NOW()")
            ->orderByRaw("(date + time)")
            ->withCount([
                'registrations as recruiting_count' => fn($q) => $q->where('status', 'pending'),
                'seats as filled_count' => fn($q) => $q->whereNotNull('character_id'),
            ])
            ->with(['type', 'host', 'fight', 'seats.ffclass', 'seats.phantom_job'])
            ->first();
        return ScheduleResource::make($schedules);
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
    public function store(ScheduleRequest $request): ScheduleResource|\Illuminate\Http\JsonResponse
    {
        $gid = $request->validated()["group_id"];
        $group = Group::findOrFail($gid);
        if(!$group->hasUser(auth()->user())) {
            return response()->json(["message" => "You don't have permission to access this group"], 403);
        }
        $schedule = new Schedule($request->validated());
        $schedule->saveOrFail();
        $schedule->refresh();
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
