<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AssignmentPolicy
{
    public function before(User $user, string $ability)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Schedule $schedule): bool
    {
        return $schedule->group->hasUser($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Assignment $assignment): bool
    {
        return $assignment->schedule->group->hasUser($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Assignment $assignment): bool
    {
        return $assignment->schedule->group->hasUser($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Assignment $assignment): bool
    {
        return $assignment->schedule->group->hasUser($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Assignment $assignment): bool
    {
        return $assignment->schedule->group->hasUser($user);
    }
}
