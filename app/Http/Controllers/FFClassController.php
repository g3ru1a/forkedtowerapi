<?php

namespace App\Http\Controllers;

use App\Http\Resources\FFClassResource;
use App\Models\FFClass;
use Illuminate\Http\Request;

class FFClassController extends Controller
{
    public function index(){
        return FFClassResource::collection(FFClass::all());
    }
}
