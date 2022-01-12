<?php

namespace Components\Connector\Mindee\Application\Data;

use Carbon\Carbon;
use Components\Connector\Mindee\Application\Extractors\ExtraitKbisExtractor;
use Components\Connector\Mindee\Domain\Interfaces\ComplianceDocumentDataInterface;

class ExtraitKbisData extends DocumentData implements ComplianceDocumentDataInterface
{
    public function getSecurityCode()
    {
        return $this->getCodeVerification();
    }

    public function getDateValidFrom(): ?Carbon
    {
        return $this->getDateMiseAJour();
    }

    public function getActivites()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_ACTIVITES);
    }

    public function getActivitesEtablissement()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_ACTIVITES_ETABLISSEMENT);
    }

    public function getAdresseSiege()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_ADRESSE_SIEGE);
    }

    public function getCapitalSocial()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_CAPITAL_SOCIAL);
    }

    public function getCodeNaf()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_CODE_NAF);
    }

    public function getCodePostalSiege()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_CODE_POSTAL_SIEGE);
    }

    public function getCodeVerification()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_CODE_VERIFICATION);
    }

    public function getDateClotureExerciceSocial()
    {
        return $this->getDate(ExtraitKbisExtractor::FIELD_DATE_CLOTURE_EXERCICE_SOCIAL);
    }

    public function getDateCloturePremierExerciceSocial()
    {
        return $this->getDate(ExtraitKbisExtractor::FIELD_DATE_CLOTURE_PREMIER_EXERCICE_SOCIAL);
    }

    public function getDateCommencementActivite()
    {
        return $this->getDate(ExtraitKbisExtractor::FIELD_DATE_COMMENCEMENT_ACTIVITE);
    }

    public function getDateImmatriculation()
    {
        return $this->getDate(ExtraitKbisExtractor::FIELD_DATE_IMMATRICULATION);
    }

    public function getDateImmatriculationOrigine()
    {
        return $this->getDate(ExtraitKbisExtractor::FIELD_DATE_IMMATRICULATION_ORIGINE);
    }

    public function getDateMiseAJour()
    {
        return $this->getDate(ExtraitKbisExtractor::FIELD_DATE_MISE_A_JOUR);
    }

    public function getDenominationSociale()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_DENOMINATION_SOCIALE);
    }

    public function getDomiciliationEnCommunImmatriculation()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_DOMICILIATION_EN_COMMUN_IMMATRICULATION);
    }

    public function getDomiciliationEnCommunNom()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_DOMICILIATION_EN_COMMUN_NOM);
    }

    public function getFormeJuridique()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_FORME_JURIDIQUE);
    }

    public function getDureePersonneMorale()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_DUREE_PERSONNE_MORALE);
    }

    public function getFinExtrait()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_FIN_EXTRAIT);
    }

    public function getNumeroSiren()
    {
        return str_replace(
            ' ',
            '',
            $this->getData(ExtraitKbisExtractor::FIELD_NUMERO_SIREN)
        );
    }

    public function getRcsVille()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_RCS_VILLE);
    }

    public function getSigle()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_SIGLE);
    }

    public function getTransfertRcsVille()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_TRANSFERT_RCS_VILLE);
    }

    public function getVilleSiege()
    {
        return $this->getData(ExtraitKbisExtractor::FIELD_VILLE_SIEGE);
    }
}
