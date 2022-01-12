<?php

namespace App\Support\Token;

use App\Contracts\TokenManagerInterface;
use App\Models\Addworking\Enterprise\Invitation;
use Carbon\Carbon;
use Firebase\JWT\JWT;

class InvitationTokenManager implements TokenManagerInterface
{
    protected $jwtConf;
    protected $contentEncryptionConf;

    public function __construct(array $jwtConf, array $contentEncryptionConf)
    {
        $this->jwtConf = $jwtConf;
        $this->contentEncryptionConf = $contentEncryptionConf;
    }

    public function decode(string $token): object
    {
        $raw = JWT::decode($token, $this->jwtConf['secret'], [$this->jwtConf['algorithm']]);

        if (isset($raw->data)) {
            return json_decode($this->decrypt($raw->data));
        }

        return $raw;
    }

    public function encode(array $payload): string
    {
        $content = [
            'iss' => 'ADDWORKING',
            'iat' => Carbon::now()->getTimestamp(),
            'exp' => Carbon::now()->addDays(Invitation::DELAY_IN_DAYS)->getTimestamp(),
            'data' => $this->encrypt(json_encode($payload))
        ];

        return JWT::encode($content, $this->jwtConf['secret'], $this->jwtConf['algorithm']);
    }

    private function decrypt(string $data): string
    {
        $result = openssl_decrypt(
            $data,
            $this->contentEncryptionConf['algorithm'],
            $this->contentEncryptionConf['secret'],
            0,
            $this->contentEncryptionConf['iv']
        );

        if ($result === false) {
            throw new \RuntimeException("Cannot decrypt data `{$data}`");
        }

        return $result;
    }

    private function encrypt(string $data): string
    {
        $result = openssl_encrypt(
            $data,
            $this->contentEncryptionConf['algorithm'],
            $this->contentEncryptionConf['secret'],
            0,
            $this->contentEncryptionConf['iv']
        );

        if ($result === false) {
            throw new \RuntimeException("Cannot encrypt data `{$data}`");
        }

        return $result;
    }
}
