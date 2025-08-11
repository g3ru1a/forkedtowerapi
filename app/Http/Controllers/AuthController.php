<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    function redirect(): \Symfony\Component\HttpFoundation\RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return \Laravel\Socialite\Facades\Socialite::driver('discord')->redirect();
    }
    function callback(Request $request){
        $discordUser = Socialite::driver('discord')->user();

        /** @var User $user */
        $user = User::firstOrCreate(
            ['discord_id' => $discordUser->id], // Unique key
            [
                'discord_username' => $discordUser->name,
                'discord_nickname' => $discordUser->user['global_name'] ?? $discordUser->user['username'],
                'discord_avatar_url' => $discordUser->avatar,
                'email' => $discordUser->email,
            ]
        );
        $tokenExpireAt = now()->addDays((int) env('TOKEN_EXPIRE_DAYS', 1));
        $accessToken = $user->createToken('auth-token', ["*"], $tokenExpireAt)->plainTextToken;
        return response()->json(['access_token' => $accessToken]);
    }

    function devAuth(Request $request){
        $user = User::first();

        $tokenExpireAt = now()->addDays((int) env('TOKEN_EXPIRE_DAYS', 1));
        $accessToken = $user->createToken('auth-token', ["*"], $tokenExpireAt)->plainTextToken;
        return response()->json(['access_token' => $accessToken]);
    }
}
