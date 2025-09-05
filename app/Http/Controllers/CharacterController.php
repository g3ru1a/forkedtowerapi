<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterUpdateRequest;
use App\Http\Requests\CreateCharacterRequest;
use App\Http\Resources\CharacterResource;
use App\Http\Resources\NodestoneCharacterResource;
use App\Http\Resources\NodestoneSearchResource;
use App\Http\Resources\VerificationResource;
use App\Models\Character;
use App\Models\OccultData;
use App\Models\PhantomJob;
use App\Services\NodestoneAPI;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;

class CharacterController extends Controller
{
    use AuthorizesRequests;

    private static function getPhantomJobsArray(): array
    {
        $cacheKey = 'schedule-types';
        $ttl = now()->addDays(30);
        return \Cache::remember($cacheKey, $ttl, function () {
            return PhantomJob::query()->orderBy('name')->pluck('id', 'name')->toArray();
        });
    }

    private static function GenerateVerificationCode(): string {
        return 'fp_' . str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
    }

    /**
     *  Search for characters stored in the DB
     * @param string $name
     * @return AnonymousResourceCollection
     */
    public function search(string $name): AnonymousResourceCollection
    {
        $characters = Character::where('verified', true)->where('name', 'LIKE', '%' . $name . '%')->limit(10)->get();
        return CharacterResource::collection($characters);
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

        //Fetch the Character data from Lodestone
        $lodestoneCharacterData = NodestoneAPI::GetCharacter($lodestone_id)->getCharacterModelData();

        $verified = str_contains($lodestoneCharacterData['bio'], $character->verification_code);

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
     * Display all characters
     */
    public function index()
    {
        return CharacterResource::collection(
            Character::where('user_id', auth()->user()->id)->where('verified', true)->with('user', 'occult_data')->paginate(30)
        );
    }

    /**
     * Store a new Character
     */
    public function store(CreateCharacterRequest $request): CharacterResource
    {
        //Cleanup the ID Param
        $lodestone_id = trim($request->get('lodestone_id'));
        //Check If Character Already exists
        $character = Character::where('lodestone_id', $lodestone_id)->first();
        if($character){
            //Load all data and return
            $character = $character->load(['occult_data', 'phantom_jobs']);
            return CharacterResource::make($character);
        }
        //Fetch the Character data from Lodestone
        $lodestoneCharacter = NodestoneAPI::GetCharacter($lodestone_id);
        //Create the base model
        $character = new Character($lodestoneCharacter->getCharacterModelData());
        $character->user()->associate(auth()->user());
        //Create The Verification Token
        $character->fill([
            'verification_code' => self::GenerateVerificationCode(),
            'expires_at' => now()->addHours(12)
        ]);
        //Persist Character in DB
        $character->saveOrFail();
        //Get the Phantom Jobs from our DB and Map them as $phantomJobs[Name] = ID
        $phantomJobs = self::getPhantomJobsArray();
        //Get the Pivot Data from the LodestoneCharacterMapper
        $pivotData = $lodestoneCharacter->getPhantomJobPivotData($phantomJobs);
        if($pivotData) $character->phantom_jobs()->sync($pivotData);
        //Get Occult Data
        $occult_data = $lodestoneCharacter->getOccultModelData();
        if($occult_data){
            $occult_data = new OccultData($occult_data);
            $occult_data->character()->associate($character);
            $occult_data->saveOrFail();
        }
        //Load all data and return
        $character = $character->load(['occult_data', 'phantom_jobs']);
        return CharacterResource::make($character);
    }

    /**
     * Get A Character's full information.
     */
    public function show(Character $character): CharacterResource
    {
        $character = $character->load(['occult_data', 'user', 'phantom_jobs']);
        return CharacterResource::make($character);
    }

    /**
     * Update the character data
     */
    public function update(CharacterUpdateRequest $request, Character $character): CharacterResource
    {
        $response = $this->authorize('update', $character);
        if($response->denied()){
            abort(403, 'Unauthorized action.');
        }
        //Cleanup the ID Param
        $lodestone_id = trim($request->get('lodestone_id'));
        //Fetch the Character data from Lodestone
        $lodestoneCharacter = NodestoneAPI::GetCharacter($lodestone_id);
        //Create the base model
        $character->fill($lodestoneCharacter->getCharacterModelData());
        //Persist Character in DB
        $character->saveOrFail();
        //Get the Phantom Jobs from our DB and Map them as $phantomJobs[Name] = ID
        $phantomJobs = self::getPhantomJobsArray();
        //Get the Pivot Data from the LodestoneCharacterMapper
        $pivotData = $lodestoneCharacter->getPhantomJobPivotData($phantomJobs);
        if($pivotData) $character->phantom_jobs()->sync($pivotData);
        //Get Occult Data
        $occult_data = $lodestoneCharacter->getOccultModelData();
        if($occult_data && $character->occult_data()->exists()){
            $character->occult_data->fill($occult_data)->saveOrFail();
        }
        //Load all data and return
        $character = $character->load(['occult_data', 'phantom_jobs']);
        return CharacterResource::make($character);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Character $character): CharacterResource
    {
        $response = $this->authorize('delete', $character);
        if($response->denied()){
            abort(403, 'Cannot execute action.');
        }
        $character->forceDelete();
        return CharacterResource::make($character);
    }
}
