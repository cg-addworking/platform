<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Validators;

use Illuminate\Support\Arr;

class ExtraitKbisValidationResponse extends DocumentValidationResponse
{
    public function getScreenshot(): ?\SplFileInfo
    {
        $path = Arr::get($this->data, 'screenshot');

        return $path ? new \SplFileInfo($path) : null;
    }

    public function getVerificationKey(): ?string
    {
        return Arr::get($this->data, 'data.verification_key');
    }

    public function getDate(): ?\DateTime
    {
        $date = Arr::get($this->data, 'data.date');

        return $date ? new \DateTime($date) : null;
    }

    public function getName(): ?string
    {
        return Arr::get($this->data, 'data.name');
    }

    public function getSiret(): ?string
    {
        return Arr::get($this->data, 'data.siret');
    }
}
