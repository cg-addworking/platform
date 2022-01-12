<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Extractors\Data;

use Components\Infrastructure\FileDataExtractor\Application\Extractors\Data\DocumentData;

class PurchaseOrderSogetrelData extends DocumentData
{
    public function getDocusignEnvelopeId(): ?string
    {
        return $this->data['docusign_envelope_id'] ?? null;
    }

    public function getCommandNumber(): ?string
    {
        return $this->data['command_number'] ?? null;
    }

    public function getWorkfieldIdentifier(): ?string
    {
        return $this->data['workfield_identifier'] ?? null;
    }

    public function getTotalEurHt(): ?string
    {
        return $this->data['total_eur_ht'] ?? null;
    }

    public function getBaseTva(): ?string
    {
        return $this->data['total_eur_tva'] ?? null;
    }

    public function getTotalEuroTTC(): ?string
    {
        return $this->data['total_eur_ttc'] ?? null;
    }

    public function getIsAutoliquidee(): ?string
    {
        return $this->data['is_autoliquidee'] ?? null;
    }

    public function getReference(): ?string
    {
        return $this->data['reference'] ?? null;
    }

    public function getIdentificationNumber(): ?string
    {
        return $this->data['prestataire_oracle_id'] ?? null;
    }
}
