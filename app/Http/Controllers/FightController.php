<?php

namespace App\Http\Controllers;

use App\Http\Resources\FightResource;
use App\Models\Fight;
use Illuminate\Http\Request;

class FightController extends Controller
{

    public function index(){
        return FightResource::collection(Fight::all());
    }

}
