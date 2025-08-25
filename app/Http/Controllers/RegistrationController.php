<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\RegistrationResource;
use App\Models\Registration;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display all registrations made by user
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $registrations = Registration::where('user_id', auth()->id())->with(['schedule', 'character'])->paginate(30);
        return RegistrationResource::collection($registrations);
    }

    /**
     * Create Registration
     * @throws \Throwable
     */
    public function store(RegistrationRequest $request): RegistrationResource
    {
        $this->authorize('create', Registration::class);

        $data = $request->validated();
        $data['flex_classes'] = join(',', $data['flex_classes']);
        $data['flex_jobs'] = join(',', $data['flex_jobs']);

        $registration = new Registration($data);
        $registration->user()->associate(auth()->user());
        $registration->saveOrFail();

        return RegistrationResource::make($registration);
    }

    /**
     * Show User's Registration
     * @throws AuthorizationException
     */
    public function show(Registration $registration): RegistrationResource
    {
        $this->authorize('view', $registration);

        $registration->load(
            'schedule','user','character'
        );
        return RegistrationResource::make($registration);
    }

    /**
     * Update Registration
     * @throws AuthorizationException
     * @throws \Throwable
     */
    public function update(RegistrationRequest $request, Registration $registration)
    {
        $this->authorize('update', $registration);
        unset($request['schedule_id']);
        unset($request['user_id']);
        unset($request['status']);
        $registration->update($request->validated());
        $registration->saveOrFail();
        return RegistrationResource::make($registration);
    }

    /**
     * @throws \Throwable
     * @throws AuthorizationException
     */
    public function deny(Registration $registration): RegistrationResource
    {
        $this->authorize('deny', $registration);
        $registration->status = 'denied';
        $registration->saveOrFail();
        return RegistrationResource::make($registration);
    }

    /**
     * Remove the registration
     * @throws AuthorizationException
     */
    public function destroy(Registration $registration): RegistrationResource
    {
        $this->authorize('delete', $registration);
        $registration->delete();
        return RegistrationResource::make($registration);
    }
}
