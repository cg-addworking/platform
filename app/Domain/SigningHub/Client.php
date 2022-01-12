<?php

namespace App\Domain\SigningHub;

use DateTime;
use DomainException;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use RuntimeException;
use Generator;

class Client
{
    const BASE_URL = 'https://api.signinghub.com';
    const VERSION  = 'v3';

    protected $token;
    protected $client;
    protected $config;

    public function __construct(string $id, string $secret, string $username, string $password)
    {
        $this->config = @compact('id', 'secret', 'username', 'password');
    }

    public function auth($cache = true): self
    {
        if ($cache && Cache::has('signinghub.auth.access_token')) {
            Log::debug('signinghub: Using access token from cache');
            $accessToken = Cache::get('signinghub.auth.access_token');
        } else {
            list($accessToken, $expiresAt) = $this->getAccessToken();
            Cache::set('signinghub.auth.access_token', $accessToken, $expiresAt);
        }

        $this->token  = $accessToken;
        $this->client = new GuzzleClient([
            'verify'          => false,
            'base_uri'        => self::BASE_URL . '/' . self::VERSION . '/',
            'headers'         => ['Authorization' => "Bearer {$accessToken}"],
            'connect_timeout' => 5,
            'read_timeout'    => 10,
        ]);

        return $this;
    }

    protected function getAccessToken(): array
    {
        Log::debug('signinghub: Authentication attempt');

        $request = (new GuzzleClient)->post(self::BASE_URL . '/authenticate', [
            'connect_timeout' => 5,
            'read_timeout'    => 10,
            'form_params'     => [
                'client_id'        => $this->config['id'],
                'client_secret'    => $this->config['secret'],
                'grant_type'       => 'password',
                'username'         => $this->config['username'],
                'password'         => $this->config['password'],
            ],
        ]);

        $response = json_decode($request->getBody());
        if (!isset($response->access_token)) {
            Log::debug("signinghub: Authentication failed", (array) $response);
            throw new RuntimeException("Could not authenticate");
        }

        Log::debug("signinghub: Authentication succeeded", (array) $response);

        $accessToken = $response->access_token;
        $expiresIn = $response->expires_in - 60;
        $expiresAt = new DateTime("+{$expiresIn} seconds");
        $refreshToken = $response->refresh_token;

        return [$accessToken, $expiresAt];
    }

    protected function request($method, $endpoint, array $data = [])
    {
        if (empty($this->client)) {
            $this->auth();
        }

        try {
            return $this->client->request($method, $endpoint, $data);
        } catch (BadResponseException $e) {
            if ($e->getResponse()->getStatusCode() != 401) {
                throw $e;
            }

            // request a new token and retry request
            return $this->auth(false)->client->request($method, $endpoint, $data);
        }
    }

    public function addPackage($name)
    {
        $request = $this->request('POST', 'packages', [
            'json' => ['package_name' => $name]
        ]);

        if ($request->getStatusCode() == 200) {
            $response = json_decode($request->getBody());
            return $response->package_id;
        }

        return false;
    }

    public function uploadDocument(string $body, string $filename, string $package)
    {
        $request = $this->request('POST', "packages/$package/documents", @compact('body') + [
            'headers' => [
                'x-file-name' => $filename,
                'x-convert-document' => 'false',
                'x-source'  => 'API',
            ],
        ]);

        if ($request->getStatusCode() == 201) {
            $response = json_decode($request->getBody());
            return $response->documentid;
        }

        return false;
    }

    public function addRecipient(string $package, $user)
    {
        $request = $this->request('POST', "packages/$package/workflow/users", [
            'json' => [$user]
        ]);

        return $request->getStatusCode() == 200;
    }

    public function getWorkflow(string $package)
    {
        try {
            $request = $this->request('GET', "packages/$package/workflow");
        } catch (ClientException $e) {
            Log::error($e->getMessage());
            return false;
        }

        if ($request->getStatusCode() == 200) {
            return json_decode($request->getBody());
        }

        return false;
    }

    public function addSignatureArea(string $package, string $document, array $fields)
    {
        $request = $this->request('POST', "packages/$package/documents/$document/fields/electronic_signature", [
            'json' => [
                'order' => $fields['order'],
                'page_no' => $fields['page'],
                'dimensions' => [
                    'x' => $fields['left'],
                    'y' => $fields['top'],
                    'width' => $fields['width'],
                    'height' => $fields['height'],
                ],
                'authentication' => [
                    'enabled' => true,
                    'sms_otp' => ['enabled' => false]
                ],
            ]
        ]);

        if (in_array($request->getStatusCode(), [200, 201])) {
            $response = json_decode($request->getBody());
            return $response->field_name;
        }

        return false;
    }

    public function addDocument(string $package, string $document)
    {
        $request = $this->request('POST', "packages/$package/documents/library/$document");

        if ($request->getStatusCode()== 201) {
            $response = json_decode($request->getBody());
            return $response;
        }

        return false;
    }

    public function addTemplate(string $package, string $document, array $config)
    {
        $request = $this->request('POST', "packages/$package/documents/$document/template", [
            'json' =>  $config
        ]);

        if ($request->getStatusCode() == 200) {
            $response = json_decode($request->getBody());
            return $response;
        }

        return false;
    }

    public function sharePackage($package)
    {
        $request = $this->request('POST', "packages/$package/workflow");

        if ($request->getStatusCode() == 200) {
            $response = json_decode($request->getBody());
            return $response;
        }

        return false;
    }

    public function getIframeSrc($package, $email): string
    {
        if (!config('signinghub.enabled')) {
            return '#';
        }

        // get a fresh token
        $this->auth(false);

        return "https://web.signinghub.com/Integration?" . http_build_query([
            'access_token' => $this->token,
            'document_id' => $package,
            'language' => 'fr-fr',
            'user_email' => $email,
        ]);
    }

    public function downloadContract(string $package, string $document)
    {
        try {
            $request = $this->request('GET', "packages/$package/documents/$document/base64", [
                'headers' =>  [
                    'Accept' => "application/octet-stream",
                ]
            ]);
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }

        if ($request->getStatusCode() == 200) {
            return $response = json_decode($request->getBody());
        }

        return false;
    }

    /**
     * Get verification results for all the digital signature fields of a document in a package
     *
     * Returns an array<struct> where struct contains the following keys:
     * + field_name
     * + signer_name
     * + signature_status
     * + signing_reason
     * + signing_location
     * + contact_information
     * + signing_time
     * + subject_dn
     *
     * @param string $package [Package ID of the package to which the document is added]
     * @param string $document [The ID of the document to be downloaded]
     * @return bool|mixed
     */
    public function getContractSignatoryDetails(string $package, string $document)
    {
        try {
            $request = $this->request('GET', "packages/$package/documents/$document/verification");
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }

        if ($request->getStatusCode() == 200) {
            return json_decode($request->getBody());
        }

        return false;
    }

    /**
     *
     * Search a text in the PDF document and place a signature field near to that searched text.
     *
     * @param string $package
     * @param string $document
     * @param array $fields {
     *     @option string search_text [Word that needs to be searched in the document]
     *     @option string placement (optional) [Possible values are LEFT, RIGHT, TOP, BOTTOM. Default = LEFT]
     *     @option integer order [Order of the user to which the fields will be assigned automatically]
     *     @option string field_type [Possible values are
     *             ELECTRONIC_SIGNATURE, DIGITAL_SIGNATURE, IN_PERSON_SIGNATURE. Default = ELECTRONIC_SIGNATURE]
     *     @option string placeholder [Placeholder is needed for IN_PERSON_SIGNATURE type of fields]
     *     @option array dimensions {
     *          (optional)
     *          integer width [Default 200px]
     *          integer height [Default 80px]
     *     }
     * }
     *
     * @return bool|mixed
     */
    public function addAutoplaceField(string $package, string $document, array $fields)
    {
        $request = $this->request('POST', "packages/$package/documents/$document/fields/autoplace", [
            'json' => [
                'search_text' => $fields['search_text'],
                'placement' => $fields['placement'],
                'order' => $fields['order'],
                'field_type' => $fields['field_type'],
                'placeholder' => $fields['placeholder'],
                'dimensions' => [
                    'width' => $fields['width'],
                    'height' => $fields['height'],
                ],
            ]
        ]);

        if (in_array($request->getStatusCode(), [200, 201])) {
            $response = json_decode($request->getBody());
            return $response;
        }

        return false;
    }

    public function addTextField(string $package, string $document, array $fields)
    {
        $request = $this->request('POST', "packages/$package/documents/$document/fields/text", [
            'json' => [
                'order' => $fields['order'],
                'page_no' => $fields['page'],
                'type' => $fields['type'],
                'format' => $fields['format'],
                'placeholder' => $fields['placeholder'],
                'value' => $fields['value'],
                'max_length' => $fields['max_length'],
                'field_type' => $fields['field_type'],
                'validation_rule' => $fields['validation_rule'],
                'dimensions' => [
                    'x' => $fields['left'],
                    'y' => $fields['top'],
                    'width' => $fields['width'],
                    'height' => $fields['height'],
                ],
            ]
        ]);

        if (in_array($request->getStatusCode(), [200, 201])) {
            $response = json_decode($request->getBody());
            return $response;
        }

        return false;
    }

    /**
     * Delete a document in a package
     *
     * @param string $package [Package ID of the package to which the document is added]
     * @param string $document [ID of the document to be deleted]
     * @return bool|mixed
     */
    public function deleteDocument(string $package, string $document)
    {
        try {
            $request = $this->request('DELETE', "packages/$package/documents/$document");
        } catch (ClientException $e) {
            Log::error($e);
            return false;
        }

        if ($request->getStatusCode() == 200) {
            Log::debug(json_decode($request->getBody()));

            return json_decode($request->getBody());
        }

        return false;
    }

    /**
     * Delete a document from the user inbox.
     *
     * @param string $package [Package ID of the package which contains the document]
     * @return bool|mixed
     */
    public function deletePackage(string $package)
    {
        try {
            $request = $this->request('DELETE', "packages/$package");
        } catch (ClientException $e) {
            Log::error($e);
            return false;
        }

        if ($request->getStatusCode() == 200) {
            Log::debug(json_decode($request->getBody()));

            return json_decode($request->getBody());
        }

        return false;
    }

    /**
     * Get a list of documents filtered by different statuses.
     * Users can divide the records into pages by providing a number of records per page
     *
     * @param string $documentStatus [Filter by document status,
     * possible values are ALL, DRAFT, PENDING, SIGNED, DECLINED, INPROGRESS, COMPLETED]
     *
     * @param int $pageNo [Page number, according the division of records per page]
     * @param int $recordsPerPage [Number of records that are needed to be fetched in one request]
     *
     * @return array|bool
     */
    public function getPackages(string $documentStatus, int $pageNo, int $recordsPerPage)
    {
        $authorizedDocumentStatus = ['ALL', 'DRAFT', 'PENDING', 'SIGNED', 'DECLINED', 'INPROGRESS', 'COMPLETED'];
        if ($recordsPerPage < 1) {
            throw new InvalidArgumentException("Records per page should be grater than ZERO, {$recordsPerPage} given");
        }

        if ($pageNo < 1) {
            throw new InvalidArgumentException("Page number should be grater than ZERO, {$pageNo} given");
        }

        if (!in_array($documentStatus, $authorizedDocumentStatus)) {
            throw new DomainException("The value {$documentStatus} is not valid for documentStatus");
        }

        try {
            $request = $this->request('GET', "packages/$documentStatus/$pageNo/$recordsPerPage");
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }

        if ($request->getStatusCode() == 200) {
            return [
                'current_page' => $pageNo,
                'last_page' => ($pageNo == 1) ? null : ($pageNo - 1),
                'next_page' => (empty(json_decode($request->getBody()))) ? null : ($pageNo + 1),
                'total_records' => $request->getHeader('x-total-records')[0],
                'data' => json_decode($request->getBody())
            ];
        }

        return false;
    }

    public function getAllPackages(): Generator
    {
        $pageNo = 1;
        do {
            $response = $this->getPackages('ALL', $pageNo, 50);
            foreach ($response['data'] as $item) {
                yield $item;
            }
            $pageNo = $response['next_page'];
        } while ($response && $response['next_page'] != null);
    }
}
