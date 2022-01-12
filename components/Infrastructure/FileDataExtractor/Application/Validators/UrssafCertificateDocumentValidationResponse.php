<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Validators;

use Illuminate\Support\Arr;

class UrssafCertificateDocumentValidationResponse extends DocumentValidationResponse
{
    public function getScreenshot(): ?\SplFileInfo
    {
        $path = Arr::get($this->data, 'screenshot');

        return $path ? new \SplFileInfo($path) : null;
    }
}
