<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Validators;

use Illuminate\Support\Arr;

class RegulariteFiscaleMicroResponse extends DocumentValidationResponse
{
    public function getScreenshot(): ?\SplFileInfo
    {
        $path = Arr::get($this->data, 'screenshot');

        return $path ? new \SplFileInfo($path) : null;
    }
    public function getVerificationKeyCode(): ?string
    {
        return Arr::get($this->data, 'data.verification_key_code');
    }

    public function getIssuingBody(): ?string
    {
        return Arr::get($this->data, 'data.issuing_body');
    }

    public function getCompanyName(): ?string
    {
        return Arr::get($this->data, 'data.company_name');
    }

    public function getDeliveredAt(): ?string
    {
        return Arr::get($this->data, 'data.delivered_at');
    }
}
