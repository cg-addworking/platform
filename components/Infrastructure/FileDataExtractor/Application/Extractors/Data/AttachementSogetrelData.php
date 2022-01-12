<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Extractors\Data;

use Components\Infrastructure\FileDataExtractor\Application\Extractors\Data\DocumentData;

class AttachementSogetrelData extends DocumentData
{
    public function getDocusignEnvelopeId(): ?string
    {
        return $this->data['docusign_envelope_id'] ?? null;
    }

    public function getContractNumber(): ?string
    {
        return $this->data['contract_num'] ?? null;
    }

    public function getAttachementNo(): ?string
    {
        return $this->data['attachement_num'] ?? null;
    }

    public function getTotalEurHt(): ?string
    {
        return $this->data['total_eur_ht'] ?? null;
    }

    public function getTotalEurTtc(): ?string
    {
        return $this->data['total_eur_ttc'] ?? null;
    }

    public function getTva(): ?string
    {
        return $this->data['total_eur_tva'] ?? null;
    }
}
