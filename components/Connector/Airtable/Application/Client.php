<?php

namespace Components\Connector\Airtable\Application;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class Client
{
    const BASE_URI_API = 'https://api.airtable.com';
    const VERSION = 'v0';

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';

    public function getRecords(string $table, string $query)
    {
        $url = self::BASE_URI_API.'/'.self::VERSION.'/'.config('airtable.api_key').'/'.$table;

        $client = new GuzzleClient([
            'connect_timeout' => 5,
            'read_timeout'    => 10,
            'debug' => false,
            'headers' => [
                'Authorization' => "Bearer ".config('airtable.token'),
            ],
        ]);

        try {
            $response = $client->request(self::METHOD_GET, $url, ['query' => $query]);
            return $this->success($url, $response);
        } catch (RequestException $exception) {
            Log::error("Airtable : (error code {$exception->getCode()}, uri {$url}) - {$exception->getMessage()}");
            return $this->fail($url, $exception);
        }
    }

    public function updateRecord(string $table, array $values = [])
    {
        $url = self::BASE_URI_API.'/'.self::VERSION.'/'.config('airtable.api_key').'/'.$table;

        $client = new GuzzleClient([
            'connect_timeout' => 5,
            'read_timeout'    => 10,
            'debug' => false,
            'headers' => [
                'Authorization' => "Bearer ".config('airtable.token'),
                'Content-Type' => 'application/json'
            ],
        ]);

        $data = json_encode($values);

        try {
            $response = $client->request(self::METHOD_PATCH, $url, ['body' => "{$data}"]);
            return $this->success($url, $response);
        } catch (RequestException $exception) {
            Log::error("Airtable : (error code {$exception->getCode()}, uri {$url}) - " .
                "{$exception->getResponse()->getBody()->getContents()}");
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
