<?php

namespace Components\Infrastructure\ElectronicSignature\Application\Yousign;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class Client
{
    protected $baseUriApi;
    protected $baseUriWebApp;
    protected $apiKey;
    protected $options;
    protected $environment;

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const ENDPOINT_PROCEDURES = '/procedures';
    const ENDPOINT_FILES = '/files';
    const ENDPOINT_MEMBERS = '/members';
    const ENDPOINT_FILE_OBJECTS = '/file_objects';
    const ENDPOINT_FILE_PROOF = '/proof?format=pdf';
    const FILE_SIGNABLE = 'signable';
    const FILE_ATTACHMENT = 'attachment';
    const USER_VALIDATOR = 'validator';
    const USER_SIGNER = 'signer';


    public function __construct()
    {
        $this->environment = config('yousign.environment');
        $this->apiKey = config('yousign.api_key');
        $this->options = [
            'connect_timeout' => 30,
            'read_timeout' => 30,
            'debug' => false,
            'headers' => [
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json'
            ]
        ];

        if ($this->environment == 'production') {
            $this->baseUriApi = 'https://api.yousign.com';
            $this->baseUriWebApp = 'https://webapp.yousign.com';
        } else {
            $this->baseUriApi = 'https://staging-api.yousign.com';
            $this->baseUriWebApp = 'https://staging-app.yousign.com';
        }
    }

    /**
     * @param string $method [GET, POST, PUT]
     * @param string $endpoint
     * @param array $data
     * @return mixed
     * @throws GuzzleException
     */
    protected function request(string $method, string $endpoint, array $data = [])
    {
        $client = new GuzzleClient(['base_uri' => $this->baseUriApi]);

        try {
            $response = $client->request($method, $endpoint, $this->options + $data);
            return json_decode(json_encode([
                'code' => $response->getStatusCode(),
                'message' => $response->getReasonPhrase(),
                'uri' => $this->baseUriApi.$endpoint,
                'body' => json_decode($response->getBody(), true),
            ]));
        } catch (RequestException $exception) {
            $uri = $this->baseUriApi.$endpoint;
            Log::error("Yousign : (error code {$exception->getCode()}, uri {$uri}) - 
                {$exception->getResponse()->getBody()->getContents()}");
            return json_decode(json_encode([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'uri' => $uri,
                'body' => null,
            ]));
        }
    }

    /**
     * https://dev.yousign.com/#0f7fe7c4-3ab0-49d9-b8c9-c89fb99041f2
     * https://dev.yousign.com/#7d263752-9404-4de8-b782-591936aae9ce
     * https://dev.yousign.com/#a99d1541-1012-4ae1-a406-bfe6d39f4467
     * Start new procedure (the start of the signing process)
     *
     * @param array $values
     *     @option string name
     *     @option string description
     *     @option boolean start
     *     @option boolean archive
     *     @option boolean ordered
     *     @option boolean initials
     * @return mixed
     * @throws GuzzleException
     */
    public function startProcedure(array $values)
    {
        $data = json_encode($values);

        return $this->request(self::METHOD_POST, self::ENDPOINT_PROCEDURES, [
            'body' => "{$data}",
        ]);
    }

    /**
     * @param $url
     * @return mixed
     * @throws GuzzleException
     */
    public function getProcedureData($yousign_procedure_id)
    {
        return $this->request(self::METHOD_GET, $yousign_procedure_id);
    }

    /**
     * https://dev.yousign.com/#adb923a8-5572-4898-9d31-f84a068b908b
     * https://dev.yousign.com/#16a67355-047c-4610-8bd1-2ab25ed8c510
     * Add file
     *
     * @param array $values
     *     @option string name
     *     @option string content (base64)
     *     @option string procedure
     *     @option string type [signable:default, attachment, signable]
     * @return mixed
     * @throws GuzzleException
     */
    public function addFile(array $values)
    {
        $data = json_encode($values);

        return $this->request(self::METHOD_POST, self::ENDPOINT_FILES, [
            'body' => "{$data}",
        ]);
    }

    /**
     * https://dev.yousign.com/#c12b75be-8bf2-4feb-a2be-65074338b5c8
     * https://dev.yousign.com/#ef8c8d03-1b1e-4e9b-8a72-a66f3face83d
     * https://dev.yousign.com/#7d263752-9404-4de8-b782-591936aae9ce
     * Add a member to sign documents
     *
     * @param array $values
     *     @option integer position
     *     @option string firstname
     *     @option string lastname
     *     @option string email
     *     @option string phone
     *     @option string procedure
     *     @option string type [signer:default, validator]
     * @return mixed
     * @throws GuzzleException
     */
    public function addMember(array $values)
    {
        $data = json_encode($values);

        return $this->request(self::METHOD_POST, self::ENDPOINT_MEMBERS, [
            'body' => "{$data}",
        ]);
    }

    /**
     * https://dev.yousign.com/#76e83e1d-ba4e-4c57-98da-fbe6de48a2f2
     * https://dev.yousign.com/#d3e9e137-9540-4222-a458-7f8e385d6186
     * Used to represent the visual of signature on documents once they have been signed.
     *
     * @param array $values
     *     @option string file
     *     @option string member
     *     @option string position (llx,lly,urx,ury)
     *     @option integer page
     *     @option string mention
     *     @option string mention2
     *     @option string reason (default:Signed by Yousign)
     * @return mixed
     * @throws GuzzleException
     */
    public function addSignature(array $values)
    {
        $data = json_encode($values);

        return $this->request(self::METHOD_POST, self::ENDPOINT_FILE_OBJECTS, [
            'body' => "{$data}",
        ]);
    }

    /**
     * https://dev.yousign.com/#67f84d7f-c88b-444b-b9c2-eb7833b23f06
     * Finish the procedure.
     *
     * @param string $procedureId
     * @return mixed
     * @throws GuzzleException
     */
    public function finishProcedure(string $procedureId)
    {
        $data = json_encode(["start" => true]);

        return $this->request(self::METHOD_PUT, $procedureId, [
            'body' => "{$data}",
        ]);
    }

    /**
     * https://dev.yousign.com/#5d072936-72d8-4892-afe9-ca2d6ae8338f
     * Download a proof of signature
     *
     * @param string $memberId
     * @return mixed
     * @throws GuzzleException
     */
    public function getProofFile(string $memberId)
    {
        return $this->request(self::METHOD_GET, $memberId.self::ENDPOINT_FILE_PROOF);
    }

    /**
     * https://dev.yousign.com/#2fcbc455-2602-4163-a5fd-deee5e78546f
     * Get uri to make in iframe
     *
     * @param string $memberId
     * @return string
     */
    public function getSignIframeUri(string $memberId, string $language): string
    {
        if ($language === 'de') {
            $interface = config("yousign.ui_interface.app_de");
        } else {
            $interface = config("yousign.ui_interface.app");
        }

        return "{$this->baseUriWebApp}/procedure/sign?members={$memberId}&signatureUi={$interface}";
    }

    /**
     * https://dev.yousign.com/#2fcbc455-2602-4163-a5fd-deee5e78546f
     * https://dev.yousign.com/#2e934354-772f-4c80-b302-fc05050c16c9
     * Get uri to make in iframe
     *
     * @param string $memberId
     * @return string
     */
    public function getValidateIframeUri(string $memberId, string $language): string
    {
        if ($language === 'de') {
            $interface = config("yousign.ui_interface.app_de");
        } else {
            $interface = config("yousign.ui_interface.app");
        }

        return "{$this->baseUriWebApp}/procedure/sign?members={$memberId}&signatureUi={$interface}";
    }

    /**
     * https://dev.yousign.com/#375f2af8-2379-4963-a46b-00dd860ce4cc
     * Download file (base64)
     *
     * @param string $fileId
     * @return mixed
     * @throws GuzzleException
     */
    public function downloadFile(string $fileId)
    {
        return $this->request(self::METHOD_GET, "{$fileId}/download");
    }

    /**
     * Delete the procedure.
     *
     * @param string $procedureId
     * @return boolean
     * @throws GuzzleException
     */
    public function delete(string $procedureId)
    {
        return $this->request(self::METHOD_DELETE, $procedureId);
    }

    public function getFinishedProcedureEmail(string $url, string $language)
    {
        return view('electronic_signature::mail.finished_procedure', compact('url', 'language'))->render();
    }

    public function getRefusedProcedureEmail(string $url, string $language)
    {
        return view('electronic_signature::mail.refused_procedure', compact('url', 'language'))->render();
    }
}
