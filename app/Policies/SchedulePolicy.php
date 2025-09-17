<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SchedulePolicy
{
    public function before(User $user, string $ability)
    {
        return $user->is_admin;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function viewAnyRegistration(User $user, Schedule $schedule): bool
    {
        return $schedule->group->hasUser($user);
    }

    public function viewAnySeat(User $user, Schedule $schedule): bool
    {
        return $schedule->public ? true : $schedule->group->hasUser($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Schedule $schedule): bool
    {
        if(!$schedule->public){
            return $schedule->group->hasUser($user);
        }
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
//        $input = request()->input();
//        $group = Group::findOrFail($input['group_id']);
//        return $group->hasUser($user);
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Schedule $schedule): bool
    {
        return $schedule->group->hasUser($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Schedule $schedule): bool
    {
        return $schedule->group->hasUser($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Schedule $schedule): bool
    {
        return $schedule->group->hasUser($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Schedule $schedule): bool
    {
        return $schedule->group->hasUser($user);
    }
}
