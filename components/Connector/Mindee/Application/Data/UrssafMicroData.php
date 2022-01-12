<?php

namespace Components\Connector\Mindee\Application\Data;

use Carbon\Carbon;
use Components\Connector\Mindee\Application\Extractors\UrssafMicroExtractor;
use Components\Connector\Mindee\Domain\Interfaces\ComplianceDocumentDataInterface;

class UrssafMicroData extends DocumentData implements ComplianceDocumentDataInterface
{
    public function getSecurityCode()
    {
        return str_replace(
            ' ',
            '',
            $this->getData(UrssafMicroExtractor::FIELD_SECURITY_CODE)
        );
    }

    public function getDateValidFrom(): ?Carbon
    {
        return $this->getDateAtObligationsDay();
    }

    public function getDateAtObligationsDay(): ?Carbon
    {
        $date = $this->getData(UrssafMicroExtractor::FIELD_DATE_AT_DAY);
        if (!is_null($date)) {
            return Carbon::createFromFormat(
                'Y-m-d',
                $date
            );
        }
        return null;
    }

    public function getCertificateRequestDate()
    {
        return $this->getData(UrssafMicroExtractor::FIELD_CERTIFICATE_REQUEST_DATE);
    }

    public function getNumeroSiret()
    {
        return str_replace(
            ' ',
            '',
            $this->getData(UrssafMicroExtractor::FIELD_NUMERO_SIRET)
        );
    }

    public function getObjet()
    {
        return $this->getData(UrssafMicroExtractor::FIELD_OBJET);
    }

    public function getFieldUpToDate()
    {
        return $this->getData(UrssafMicroExtractor::FIELD_UP_TO_DATE);
    }

    public function getFieldDateAtDay()
    {
        return $this->getData(UrssafMicroExtractor::FIELD_DATE_AT_DAY);
    }

    public function getFieldDateAtDayNumber()
    {
        return $this->getData(UrssafMicroExtractor::FIELD_DATE_AT_DAY_NUMBER);
    }

    public function getFieldSocialSecurityNumber()
    {
        return $this->getData(UrssafMicroExtractor::FIELD_SOCIAL_SECURITY_NUMBER);
    }

    public function getFieldTiNumber()
    {
        return $this->getData(UrssafMicroExtractor::FIELD_TI_NUMBER);
    }

    public function getFieldConcernedPerson()
    {
        return $this->getData(UrssafMicroExtractor::FIELD_CONCERNED_PERSON);
    }
}
