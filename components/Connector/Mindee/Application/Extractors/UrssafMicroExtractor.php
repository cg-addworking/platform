<?php

namespace Components\Connector\Mindee\Application\Extractors;

use Components\Connector\Mindee\Application\Data\UrssafMicroData;
use Components\Connector\Mindee\Domain\Interfaces\DocumentExtractorInterface;

class UrssafMicroExtractor extends DocumentExtractor implements DocumentExtractorInterface
{
    const FIELD_UP_TO_DATE               = 'a_jour';
    const FIELD_SECURITY_CODE            = 'code_securite';
    const FIELD_DATE_AT_DAY              = 'date_a_jour';
    const FIELD_DATE_AT_DAY_NUMBER       = 'date_a_jour_nombre';
    const FIELD_CERTIFICATE_REQUEST_DATE = 'date_demande_attestation';
    const FIELD_SOCIAL_SECURITY_NUMBER   = 'numero_securite_sociale';
    const FIELD_NUMERO_SIRET             = 'numero_siret';
    const FIELD_TI_NUMBER                = 'numero_ti';
    const FIELD_CONCERNED_PERSON         = 'personne_concernee';
    const FIELD_OBJET                    = 'objet';

    public function getData(string $file_content): UrssafMicroData
    {
        return new UrssafMicroData($this->extract($this->client->urssafMicroScan($file_content)));
    }
}
