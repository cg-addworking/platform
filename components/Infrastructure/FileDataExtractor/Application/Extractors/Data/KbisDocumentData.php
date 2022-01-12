<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Extractors\Data;

use Components\Infrastructure\FileDataExtractor\Application\Extractors\Data\DocumentData;

class KbisDocumentData extends DocumentData
{
    public function getSiretNumber(): ?string
    {
        return $this->data['siret_number'] ?? null;
    }

    public function getCompanyName(): ?string
    {
        return $this->data['company_name'] ?? null;
    }

    public function getDate(): ?\DateTime
    {
        return $this->data['date'] ?? null;
    }

    public function getVerificationKey(): ?string
    {
        return $this->data['verification_key'] ?? null;
    }
}
