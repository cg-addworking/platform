<?php

namespace Components\Connector\Pappers\Application;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class Client
{
    const BASE_URI_API = 'https://api.pappers.fr';
    const BASE_URI_API_SUGGESTIONS = 'https://suggestions.pappers.fr';
    const ENDPOINT_ENTERPRISE = 'entreprise';
    const VERSION = 'v2';
    const METHOD_GET = 'GET';

    public function getEnterprise(array $params)
    {
        $url = self::BASE_URI_API.'/'.self::VERSION.'/'.self::ENDPOINT_ENTERPRISE;
        return $this->request($url, $params, true);
    }

    public function suggestions(array $params)
    {
        $url = self::BASE_URI_API_SUGGESTIONS.'/'.self::VERSION;
        $params['cibles'] = "nom_entreprise,siren,siret,representant";
        $params['longueur'] = 20;

        return $this->request($url, $params);
    }

    protected function request(string $url, array $params, bool $need_api_key = false)
    {
        $client = new GuzzleClient([
            'connect_timeout' => 5,
            'read_timeout'    => 5,
            'debug' => false,
            'headers' => [
                'Content-Type' => 'application/json'
            ],
        ]);

        if ($need_api_key) {
            $params = array_merge_recursive(['api_token' => config('pappers.api_key')], $params);
        }

        try {
            $response = $client->request(self::METHOD_GET, $url, ['query' => $params]);
            return $this->success($url, $response);
        } catch (RequestException $exception) {
            $code = $exception->getCode();
            $message = $exception->getResponse()->getBody()->getContents();
            Log::error("Pappers : (error code {$code}, uri {$url}) - {$message}");

            return $this->fail($url, $exception);
        }
    }

    protected function success(string $url, $response)
    {
        return json_decode(json_encode([
            'code' => $response->getStatusCode(),
            'message' => $response->getReasonPhrase(),
            'uri' => $url,
            'body' => json_decode($response->getBody(), true),
        ]));
    }

    protected function fail(string $url, $exception)
    {
        return json_decode(json_encode([
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'uri' => $url,
            'body' => null,
        ]));
    }
}
