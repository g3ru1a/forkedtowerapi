<?php

namespace App\Services;

use App\DataMappers\LodestoneCharacterMapper;
use App\Http\Resources\CharacterResource;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Predis\Connection\ConnectionException;

class NodestoneAPI {

    private static function GetRequest(): PendingRequest
    {
        return Http::baseUrl(config('services.nodestone.url'))
            ->acceptJson()
            ->timeout(config('services.nodestone.timeout'))
            ->retry(
                (int) config('services.nodestone.retries'),
                (int) config('services.nodestone.retry_sleep_ms')
            );
    }

    public static function GetCharacter(int $lodestone_id): LodestoneCharacterMapper
    {
        try {
            $response = NodestoneAPI::GetRequest()->get('/Character/'.$lodestone_id.'?data=CJ');
        }catch(ConnectionException $e){
            report($e);
            abort(502, 'Lodestone Upstream Unavailable');
        }

        if($response->failed()){
            abort($response->status() ?: 502, 'Lodestone upstream unavailable');
        }

        return new LodestoneCharacterMapper($response->json());
    }

    public static function SearchCharacters(string $name)
    {

    }

}
