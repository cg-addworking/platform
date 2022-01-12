<?php

namespace Components\Connector\Mindee\Application\Data;

use Carbon\Carbon;
use Components\Connector\Mindee\Application\Extractors\RegularisationFiscaleMicroExtractor;
use Components\Connector\Mindee\Domain\Interfaces\ComplianceDocumentDataInterface;

class RegularisationFiscaleMicroData extends DocumentData implements ComplianceDocumentDataInterface
{
    public function getSecurityCode()
    {
        return str_replace(
            ' ',
            '',
            $this->getData(RegularisationFiscaleMicroExtractor::FIELD_CODE_SECURITE)
        );
    }

    public function getDateValidFrom(): ?Carbon
    {
        return $this->getDate(RegularisationFiscaleMicroExtractor::FIELD_DATE_ATTESTATION);
    }

    public function getAnneeDetailRecettes()
    {
        return $this->getData(RegularisationFiscaleMicroExtractor::FIELD_ANNEE_DETAIL_RECETTES);
    }

    public function getCaLocationDeMeubleDeTourismeClasse()
    {
        return $this->getData(RegularisationFiscaleMicroExtractor::FIELD_CA_LOCATION_DE_MEUBLE_DE_TOURISME_CLASSE);
    }

    public function getCaPrestationsBic()
    {
        return $this->getData(RegularisationFiscaleMicroExtractor::FIELD_CA_PRESTATIONS_BIC);
    }

    public function getCaPrestationsBnc()
    {
        return $this->getData(RegularisationFiscaleMicroExtractor::FIELD_CA_PRESTATIONS_BNC);
    }

    public function getCaVentes()
    {
        return $this->getData(RegularisationFiscaleMicroExtractor::FIELD_CA_VENTES);
    }

    public function getCodeSecurite()
    {
        return $this->getData(RegularisationFiscaleMicroExtractor::FIELD_CODE_SECURITE);
    }

    public function getDateAttestation()
    {
        return $this->getData(RegularisationFiscaleMicroExtractor::FIELD_DATE_ATTESTATION);
    }

    public function getNumeroSecuriteSociale()
    {
        return $this->getData(RegularisationFiscaleMicroExtractor::FIELD_NUMERO_SECURITE_SOCIALE);
    }

    public function getNumeroSiret()
    {
        return str_replace(
            ' ',
            '',
            $this->getData(RegularisationFiscaleMicroExtractor::FIELD_NUMERO_SIRET)
        );
    }

    public function getNumeroTi()
    {
        return $this->getData(RegularisationFiscaleMicroExtractor::FIELD_NUMERO_TI);
    }
}
