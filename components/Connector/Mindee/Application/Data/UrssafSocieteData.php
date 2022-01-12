<?php

namespace Components\Connector\Mindee\Application\Data;

use Carbon\Carbon;
use Components\Connector\Mindee\Application\Extractors\UrssafSocieteExtractor;
use Components\Connector\Mindee\Domain\Interfaces\ComplianceDocumentDataInterface;

class UrssafSocieteData extends DocumentData implements ComplianceDocumentDataInterface
{
    public function getSecurityCode()
    {
        return str_replace(
            ' ',
            '',
            $this->getData(UrssafSocieteExtractor::FIELD_SECURITY_CODE)
        );
    }

    public function getDateValidFrom(): ?Carbon
    {
        return $this->getDateAtObligationsDay();
    }

    public function getDateAtObligationsDay(): ?Carbon
    {
        return $this->getDate(UrssafSocieteExtractor::FIELD_DATE_AT_OBLIGATIONS_DAY);
    }

    public function getCertificateRequestDate()
    {
        return $this->getData(UrssafSocieteExtractor::FIELD_CERTIFICATE_REQUEST_DATE);
    }

    public function getSirenNumber()
    {
        return str_replace(
            ' ',
            '',
            $this->getData(UrssafSocieteExtractor::FIELD_SIREN_NUMBER)
        );
    }

    public function getConcernedSiretNumber()
    {
        return $this->getData(UrssafSocieteExtractor::FIELD_CONCERNED_SIRET_NUMBER);
    }

    public function getObjet()
    {
        return $this->getData(UrssafSocieteExtractor::FIELD_OBJET);
    }
}
