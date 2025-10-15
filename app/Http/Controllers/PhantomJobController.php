<?php

namespace App\Http\Controllers;

use App\Http\Resources\BarePhantomJobResource;
use App\Http\Resources\PhantomJobResource;
use App\Models\PhantomJob;
use Illuminate\Http\Request;

class PhantomJobController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return BarePhantomJobResource::collection(PhantomJob::all());
    }
}
