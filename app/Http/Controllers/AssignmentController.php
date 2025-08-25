<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentRequest;
use App\Http\Requests\CreateAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Http\Resources\AssignmentResource;
use App\Models\Assignment;
use App\Models\Registration;
use App\Models\Schedule;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Create a new assignment
     * @throws \Throwable
     */
    public function store(CreateAssignmentRequest $request): AssignmentResource
    {
        $schedule = Schedule::findOrFail($request->get('schedule_id'));
        $this->authorize('create', $schedule);

        $registration = Registration::findOrFail($request->get('registration_id'));
        $registration->status = 'approved';

        $assignment = new Assignment($request->validated());
        $assignment->saveOrFail();

        return AssignmentResource::make($assignment);
    }

    /**
     * Update the assignment
     * @throws \Throwable
     */
    public function update(UpdateAssignmentRequest $request, Assignment $assignment): AssignmentResource
    {
        $this->authorize('update', $assignment);

        $assignment->update($request->validated());
        $assignment->saveOrFail();

        return AssignmentResource::make($assignment);
    }

    /**
     * Remove the assignment
     * @throws AuthorizationException
     */
    public function destroy(Assignment $assignment): AssignmentResource
    {
        $this->authorize('delete', $assignment);
        $assignment->delete();
        return AssignmentResource::make($assignment);
    }
}
