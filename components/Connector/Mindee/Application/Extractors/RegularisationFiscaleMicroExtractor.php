<?php

namespace Components\Connector\Mindee\Application\Extractors;

use Components\Connector\Mindee\Application\Data\RegularisationFiscaleMicroData;
use Components\Connector\Mindee\Domain\Interfaces\DocumentExtractorInterface;

class RegularisationFiscaleMicroExtractor extends DocumentExtractor implements DocumentExtractorInterface
{
    const FIELD_ANNEE_DETAIL_RECETTES = 'annee_detail_recettes';
    const FIELD_CA_LOCATION_DE_MEUBLE_DE_TOURISME_CLASSE = 'ca_location_de_meuble_de_tourisme_classe';
    const FIELD_CA_PRESTATIONS_BIC = 'ca_prestations_bic';
    const FIELD_CA_PRESTATIONS_BNC = 'ca_prestations_bnc';
    const FIELD_CA_VENTES = 'ca_ventes';
    const FIELD_CODE_SECURITE = 'code_securite';
    const FIELD_DATE_ATTESTATION = 'date_attestation';
    const FIELD_NUMERO_SECURITE_SOCIALE = 'numero_securite_sociale';
    const FIELD_NUMERO_SIRET = 'numero_siret';
    const FIELD_NUMERO_TI = 'numero_ti';

    public function getData(string $file_content): RegularisationFiscaleMicroData
    {
        return new RegularisationFiscaleMicroData($this->extract(
            $this->client->regularisationFiscaleMicroScan($file_content)
        ));
    }
}
