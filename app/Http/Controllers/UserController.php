<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function getUser(Request $request){
        $user = $request->user();
        return UserResource::make($user);
    }
}
