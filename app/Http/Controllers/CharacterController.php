<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterUpdateRequest;
use App\Http\Requests\CreateCharacterRequest;
use App\Http\Resources\CharacterResource;
use App\Http\Resources\NodestoneCharacterResource;
use App\Http\Resources\NodestoneSearchResource;
use App\Http\Resources\VerificationResource;
use App\Models\Character;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;

class CharacterController extends Controller
{
    use AuthorizesRequests;

    /**
     *  Search for characters stored in the DB
     * @param string $name
     */
    public function search(string $name){

    }

    /**
     * Verifiy the user owns the character
     *
     * @param int $lodestone_id
     * @return VerificationResource
     */
    public function verify(int $lodestone_id): VerificationResource
    {
        $lodestone_id = trim($lodestone_id);
        $character = Character::where('lodestone_id', $lodestone_id)->firstOrFail();

        $response = $this->authorize('update', $character);
        if($response->denied()){
            abort(403, 'Unauthorized action.');
        }

        try{
            $response = NodestoneController::characterRequest($lodestone_id);
        }catch(ConnectionException $e){
            report($e);
            abort(502, 'Search upstream unavailable');
        }

        if($response->failed()) abort(502, 'Search upstream unavailable');

        $lodestoneCharacter = data_get($response->json(), 'Character', null);
        $verified = str_contains($lodestoneCharacter['Bio'], $character->verification_code);

        $character->verified = $verified;
        $character->attempts = $character->attempts + 1;
        $character->verified_at = $verified ? now() : null;

        $character->saveOrFail();

        return VerificationResource::make([
            'verified' => $verified,
            'character_id' =>  $character->id,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CharacterResource::collection(
            Character::where('verified', true)->paginate(30)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCharacterRequest $request): CharacterResource
    {
        $lodestone_id = trim($request->get('lodestone_id'));
        try{
            $response = NodestoneController::characterRequest($lodestone_id);
        }catch(ConnectionException $e){
            report($e);
            abort(502, 'Search upstream unavailable');
        }
        if($response->failed()) abort(502, 'Search upstream unavailable');

        $lodestoneCharacter = data_get($response->json(), 'Character', null);
        $verification_code = 'ft_' . str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
        $character = Character::create([
            'user_id' => $request->user()->id,
            'lodestone_id' =>  $lodestone_id,
            'name' => $lodestoneCharacter['Name'],
            'world' => $lodestoneCharacter['World'],
            'datacenter' => $lodestoneCharacter['DC'],
            'avatar_url' => $lodestoneCharacter['Avatar'],
            'verification_code' => $verification_code,
            'expires_at' => now()->addHours(12),
        ]);

        return CharacterResource::make($character);
    }

    /**
     * Display the specified resource.
     */
    public function show(Character $character): CharacterResource
    {
        return CharacterResource::make($character);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CharacterUpdateRequest $request, Character $character): CharacterResource
    {
        $response = $this->authorize('update', $character);
        if($response->denied()){
            abort(403, 'Unauthorized action.');
        }
        $lodestone_id = trim($request->get('lodestone_id'));
        try{
            $response = NodestoneController::characterRequest($lodestone_id);
        }catch(ConnectionException $e){
            report($e);
            abort(502, 'Search upstream unavailable');
        }
        if($response->failed()) abort(502, 'Search upstream unavailable');

        $lodestoneCharacter = data_get($response->json(), 'Character', null);

        $character->name = $lodestoneCharacter['Name'];
        $character->world = $lodestoneCharacter['World'];
        $character->datacenter = $lodestoneCharacter['DC'];
        $character->avatar_url = $lodestoneCharacter['Avatar'];

        return CharacterResource::make($character);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Character $character): CharacterResource
    {
        $response = $this->authorize('update', $character);
        if($response->denied()){
            abort(403, 'Unauthorized action.');
        }
        $character->delete();
        return CharacterResource::make($character);
    }
}
