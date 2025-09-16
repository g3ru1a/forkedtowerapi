<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSeatRequest;
use App\Http\Resources\SeatResource;
use App\Models\Seat;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    use AuthorizesRequests;
//    /**
//     * Display a listing of the resource.
//     */
//    public function index()
//    {
//        //
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     */
//    public function store(Request $request)
//    {
//        //
//    }

    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show(Seat $seat): SeatResource
    {
        $this->authorize('view', $seat);
        return SeatResource::make($seat);
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     * @throws \Throwable
     */
    public function update(UpdateSeatRequest $request, Seat $seat): SeatResource
    {
        $this->authorize('update', $seat);
        $seat->update($request->validated());
        $seat->saveOrFail();
        return SeatResource::make($seat);
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     * @throws \Throwable
     */
    public function destroy(Seat $seat): SeatResource
    {
        $this->authorize('delete', $seat);
        $seat->update([
            'character_id' => null,
            'class_id' => null,
            'registration_id' => null,
            'is_raidlead' => false,
            'is_helper' => false,
            'phantom_job_id' => null,
        ]);
        $seat->saveOrFail();
        return SeatResource::make($seat);
    }
}
