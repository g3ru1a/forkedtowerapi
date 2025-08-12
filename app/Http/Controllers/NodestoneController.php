<?php

namespace App\Http\Controllers;

use App\Http\Resources\NodestoneCharacterResource;
use App\Http\Resources\NodestoneSearchResource;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;

class NodestoneController extends Controller
{
    /**
     * HTTP Request to Nodestone to find the character by ID
     * @param int $lodestone_id
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws ConnectionException
     */
    public static function characterRequest(int $lodestone_id): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
    {
        return Http::baseUrl(config('services.nodestone.url'))
            ->acceptJson()
            ->timeout(config('services.nodestone.timeout'))
            ->retry(
                (int) config('services.nodestone.retries'),
                (int) config('services.nodestone.retry_sleep_ms')
            )
            ->get('/Character/'.$lodestone_id);
    }

    /**
     * HTTP Request to Nodestone to search for characters by Name
     * @param string $name
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws ConnectionException
     */
    public static function searchRequest(string $name): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
    {
        return Http::baseUrl(config('services.nodestone.url'))
            ->acceptJson()
            ->timeout(config('services.nodestone.timeout'))
            ->retry(
                (int) config('services.nodestone.retries'),
                (int) config('services.nodestone.retry_sleep_ms')
            )
            ->get('/Character/Search', ['name' => $name]);
    }

    /**
     * Run a search query on Nodestone by name
     * @param string $name
     * @return AnonymousResourceCollection
     */
    public function search(string $name): AnonymousResourceCollection
    {
        $name = trim($name);

        $cacheKey = 'ns:search:'.sha1(mb_strtolower($name));
        $ttl = now()->addSeconds((int) config('services.nodestone.cache_ttl'));

        $payload = \Cache::remember($cacheKey, $ttl, function () use ($name) {
            try{
                $response = NodestoneController::searchRequest($name);
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
    public function find(int $lodestone_id): NodestoneCharacterResource
    {
        $lodestone_id = trim($lodestone_id);

        $cacheKey = 'ns:character:'.sha1(mb_strtolower($lodestone_id));
        $ttl = now()->addSeconds((int) config('services.nodestone.cache_ttl'));

        $payload = \Cache::remember($cacheKey, $ttl, function () use ($lodestone_id) {
            try{
                $response = NodestoneController::characterRequest($lodestone_id);
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
}
