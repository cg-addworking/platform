<?php

namespace Components\Connector\Mindee\Application;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class Client
{
    const BASE_URI_API = 'https://api.mindee.net';
    const ENDPOINT_URSSAF_SOCIETE = 'urssaf_societe';
    const ENDPOINT_URSSAF_MICRO = 'urssaf_micro';
    const ENDPOINT_KBIS_SOCIETE = 'kbis_societe';
    const ENDPOINT_EXTRAIT_KBIS = 'extrait_kbis';
    const ENDPOINT_REGULARITE_FISCAL_MICRO = 'rfmicro';
    const ENDPOINT_CLASSIFICATION_EXTRAIT_KBIS_OR_EXTRAIT_D1 = 'classification_extrait_kbis_or_extrait_d1';
    const ENDPOINT_PRODUCT = 'products/AddWorking';
    const ENDPOINT_PREDICT = 'v1/predict';
    const VERSION = 'v1';
    const METHOD_POST = 'POST';

    public function urssafSocieteScan(string $file_content)
    {
        return $this->request(
            $this->getUrl(self::ENDPOINT_URSSAF_SOCIETE),
            ['document' => base64_encode($file_content)],
            config('mindee.api_keys.urssaf_societe')
        );
    }

    public function urssafMicroScan(string $file_content)
    {
        return $this->request(
            $this->getUrl(self::ENDPOINT_URSSAF_MICRO),
            ['document' => base64_encode($file_content)],
            config('mindee.api_keys.urssaf_micro')
        );
    }

    public function kbisSocieteScan(string $file_content)
    {
        return $this->request(
            $this->getUrl(self::ENDPOINT_KBIS_SOCIETE),
            ['document' => base64_encode($file_content)],
            config('mindee.api_keys.kbis_societe')
        );
    }

    public function extraitKbisScan(string $file_content)
    {
        // todo : A utiliser pour appeller le SDK
        return $this->request(
            config('mindee.endpoints.node_extrait_kbis_api'),
            [
                'document' => base64_encode($file_content),
                'api_url' => $this->getUrl(self::ENDPOINT_EXTRAIT_KBIS)
            ],
            config('mindee.api_keys.extrait_kbis')
        );
    }

    public function classificationExtraitKbisOrExtraitD1Scan(string $file_content)
    {
        return $this->request(
            $this->getUrl(self::ENDPOINT_CLASSIFICATION_EXTRAIT_KBIS_OR_EXTRAIT_D1),
            ['document' => base64_encode($file_content)],
            config('mindee.api_keys.classification_extrait_kbis_or_extrait_d1')
        );
    }

    public function regularisationFiscaleMicroScan(string $file_content)
    {
        return $this->request(
            $this->getUrl(self::ENDPOINT_REGULARITE_FISCAL_MICRO),
            ['document' => base64_encode($file_content)],
            config('mindee.api_keys.regularisation_fiscale_micro')
        );
    }

    protected function request(string $url, array $params, string $api_key)
    {
        $client = new GuzzleClient([
            'connect_timeout' => 30,
            'read_timeout'    => 30,
            'debug' => false,
            'headers' => [
                'Content-Type' => 'multipart/form-data',
                'Authorization' => "Token ".$api_key,
            ],
        ]);

        try {
            $response = $client->request(self::METHOD_POST, $url, ['form_params' => $params]);
            return $this->success($url, $response);
        } catch (RequestException $exception) {
            $code = $exception->getCode();
            $message = $exception->getResponse()->getBody()->getContents();
            Log::error("Mindee : (error code {$code}, uri {$url}) - {$message}");

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
            'message' => $exception->getResponse()->getBody()->getContents(),
            'uri' => $url,
            'body' => null,
        ]));
    }

    private function getUrl(string $endpoint)
    {
        return self::BASE_URI_API.'/'.self::VERSION.'/'.self::ENDPOINT_PRODUCT.'/'.$endpoint.'/'.self::ENDPOINT_PREDICT;
    }
}
