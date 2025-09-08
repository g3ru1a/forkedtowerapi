<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\ScheduleResource;
use App\Models\Group;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    use AuthorizesRequests;

    function random_base64url(int $length): string {
        $raw = random_bytes((int) ceil($length * 0.75)); // base64 expands ≈ 4/3
        $b64 = rtrim(strtr(base64_encode($raw), '+/', '-_'), '=');
        return substr($b64, 0, $length);
    }

    /**
     * Add a user to the group
     * @param Group $group
     * @param User $user
     * @return GroupResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function add_member(Group $group, User $user): GroupResource
    {
        $this->authorize('members', $group);
        if(!$group->members->contains('id', $user->id))
            $group->members()->attach($user);
        return GroupResource::make($group->load('members'));
    }

    /**
     * Remove a user from the group
     * @param Group $group
     * @param User $user
     * @return GroupResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function remove_member(Group $group, User $user): GroupResource
    {
        $this->authorize('members', $group);
        if($group->members->contains('id', $user->id))
            $group->members()->detach($user);
        return GroupResource::make($group->load('members'));
    }

    /**
     * Display all schedules made by the group
     */
    public function schedules(Group $group): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->authorize('viewSchedules', $group);
        $schedules = $group->schedules()->paginate(30);
        return ScheduleResource::collection($schedules);
    }

    /**
     * Display all groups
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return GroupResource::collection(Group::where('user_id', auth()->user()->id)->with('owner')->get());
    }

    /**
     * Store a new group
     */
    public function store(GroupRequest $request): GroupResource
    {
        $private_path = $this->random_base64url(10);
        $group = new Group($request->validated());
        $group->private_path = $private_path;
        $group->owner()->associate(auth()->user());
        $group->saveOrFail();
        return GroupResource::make($group);
    }

    /**
     * Display the group details
     */
    public function show(Group $group): GroupResource
    {
        return GroupResource::make($group->load('owner', 'members'));
    }

    /**
     * Update the group info
     */
    public function update(GroupRequest $request, Group $group): GroupResource
    {
        $this->authorize('update', $group);
        $group->fill($request->validated());
        $group->saveOrFail();
        return GroupResource::make($group);
    }

    /**
     * Remove the group
     */
    public function destroy(Group $group): GroupResource
    {
        $this->authorize('destroy', $group);
        $group->delete();
        return GroupResource::make($group);
    }
}
