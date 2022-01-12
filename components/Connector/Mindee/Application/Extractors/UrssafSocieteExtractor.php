<?php

namespace Components\Connector\Mindee\Application\Extractors;

use Components\Connector\Mindee\Application\Data\UrssafSocieteData;
use Components\Connector\Mindee\Domain\Interfaces\DocumentExtractorInterface;

class UrssafSocieteExtractor extends DocumentExtractor implements DocumentExtractorInterface
{
    const FIELD_SECURITY_CODE             = 'code_securite';
    const FIELD_DATE_AT_OBLIGATIONS_DAY   = 'date_a_jour_obligations';
    const FIELD_CERTIFICATE_REQUEST_DATE  = 'date_demande_attestation';
    const FIELD_SIREN_NUMBER              = 'numero_siren';
    const FIELD_CONCERNED_SIRET_NUMBER    = 'numeros_siret_concernes';
    const FIELD_OBJET                     = 'objet';

    public function getData(string $file_content): UrssafSocieteData
    {
        return new UrssafSocieteData($this->extract($this->client->urssafSocieteScan($file_content)));
    }
}
