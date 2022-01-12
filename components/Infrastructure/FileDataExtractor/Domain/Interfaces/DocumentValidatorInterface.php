<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Interfaces;

use App\Models\Addworking\Enterprise\Document;
use Components\Connector\Mindee\Domain\Interfaces\ComplianceDocumentDataInterface;

interface DocumentValidatorInterface
{
    public function checkProofOfAuthenticity(string $key_code): DocumentValidationResponseInterface;
    public function specificValidation(
        ComplianceDocumentDataInterface $data,
        Document $document,
        bool $prevalidation
    ): bool;
}
