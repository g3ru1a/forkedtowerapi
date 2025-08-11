<?php

namespace App\Http\Controllers;

use App\Http\Resources\NodestoneCharacterResource;
use App\Http\Resources\NodestoneSearchResource;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;

class CharacterController extends Controller
{
    /**
     * Run a search query on Nodestone by name
     * @param string $name
     * @return AnonymousResourceCollection
     */
    public function searchNodestone(string $name): AnonymousResourceCollection
    {
        $name = trim($name);

        $cacheKey = 'ns:search:'.sha1(mb_strtolower($name));
        $ttl = now()->addSeconds((int) config('services.nodestone.cache_ttl'));

        $payload = \Cache::remember($cacheKey, $ttl, function () use ($name) {
             try{
                 $response = Http::baseUrl(config('services.nodestone.url'))
                     ->acceptJson()
                     ->timeout(config('services.nodestone.timeout'))
                     ->retry(
                         (int) config('services.nodestone.retries'),
                         (int) config('services.nodestone.retry_sleep_ms')
                     )
                     ->get('/Character/Search', ['name' => $name]);
             }catch(ConnectionException $e){
                 report($e);
                 abort(502, 'Search upstream unavailable');
             }

             if($response->failed()){
                 abort($response->status() ?: 502, 'Search upstream unavailable');
             }

             return $response->json();
        });

        $list = data_get($payload, 'List', []);
        return NodestoneSearchResource::collection($list);
    }

    /**
     * Search Nodestone for a specific character by its Lodestone ID
     * @param int $lodestone_id
     * @return NodestoneCharacterResource
     */
    public function getCharacterNodestone(int $lodestone_id): NodestoneCharacterResource
    {
        $lodestone_id = trim($lodestone_id);

        $cacheKey = 'ns:character:'.sha1(mb_strtolower($lodestone_id));
        $ttl = now()->addSeconds((int) config('services.nodestone.cache_ttl'));

        $payload = \Cache::remember($cacheKey, $ttl, function () use ($lodestone_id) {
            try{
                $response = Http::baseUrl(config('services.nodestone.url'))
                    ->acceptJson()
                    ->timeout(config('services.nodestone.timeout'))
                    ->retry(
                        (int) config('services.nodestone.retries'),
                        (int) config('services.nodestone.retry_sleep_ms')
                    )
                    ->get('/Character/'.$lodestone_id);
            }catch(ConnectionException $e){
                report($e);
                abort(502, 'Search upstream unavailable');
            }

            if($response->failed()){
                abort($response->status() ?: 502, 'Search upstream unavailable');
            }

            return $response->json();
        });

        $character = data_get($payload, 'Character', null);
        return NodestoneCharacterResource::make($character);
    }

    /**
     *  Search for characters stored in the DB
     * @param string $name
     */
    public function search(string $name){

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
