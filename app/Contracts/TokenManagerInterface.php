<?php

namespace App\Contracts;

interface TokenManagerInterface
{
    public function decode(string $token): object;

    public function encode(array $payload): string;
}
