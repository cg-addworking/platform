<?php

namespace Components\Connector\Mindee\Application\Data;

use Carbon\Carbon;
use Components\Connector\Mindee\Application\Extractors\KbisSocieteExtractor;
use Components\Connector\Mindee\Domain\Interfaces\ComplianceDocumentDataInterface;

class KbisSocieteData extends DocumentData implements ComplianceDocumentDataInterface
{
    public function getSecurityCode()
    {
        return '';
    }

    public function getDateValidFrom(): ?Carbon
    {
        return $this->getDateMiseAJour();
    }

    public function getActivites()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_ACTIVITES);
    }

    public function getActivitesEtablissement()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_ACTIVITES_ETABLISSEMENT);
    }

    public function getAdresseDomicilePersonnel1()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_ADRESSE_DOMICILE_PERSONNEL_1);
    }

    public function getAdresseDomicilePersonnel2()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_ADRESSE_DOMICILE_PERSONNEL_2);
    }

    public function getAdresseDomicilePersonnel3()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_ADRESSE_DOMICILE_PERSONNEL_3);
    }

    public function getAdresseDomicilePersonnel4()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_ADRESSE_DOMICILE_PERSONNEL_4);
    }

    public function getAdresseSiege()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_ADRESSE_SIEGE);
    }

    public function getCapitalSocial()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_CAPITAL_SOCIAL);
    }

    public function getCodeNaf()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_CODE_NAF);
    }

    public function getCodePostalDomicilePersonnel1()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_CODE_POSTAL_DOMICILE_PERSONNEL_1);
    }

    public function getCodePostalDomicilePersonnel2()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_CODE_POSTAL_DOMICILE_PERSONNEL_2);
    }

    public function getCodePostalDomicilePersonnel3()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_CODE_POSTAL_DOMICILE_PERSONNEL_3);
    }

    public function getCodePostalDomicilePersonnel4()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_CODE_POSTAL_DOMICILE_PERSONNEL_4);
    }

    public function getCodePostalSiege()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_CODE_POSTAL_SIEGE);
    }

    public function getCodeVerification()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_CODE_VERIFICATION);
    }

    public function getDateClotureExerciceSocial()
    {
        return $this->getDate(KbisSocieteExtractor::FIELD_DATE_CLOTURE_EXERCICE_SOCIAL);
    }

    public function getDateCloturePremierExerciceSocial()
    {
        return $this->getDate(KbisSocieteExtractor::FIELD_DATE_CLOTURE_PREMIER_EXERCICE_SOCIAL);
    }

    public function getDateCommencementActivite()
    {
        return $this->getDate(KbisSocieteExtractor::FIELD_DATE_COMMENCEMENT_ACTIVITE);
    }

    public function getDateDeNaissance1()
    {
        return $this->getDate(KbisSocieteExtractor::FIELD_DATE_DE_NAISSANCE_1);
    }

    public function getDateDeNaissance2()
    {
        return $this->getDate(KbisSocieteExtractor::FIELD_DATE_DE_NAISSANCE_2);
    }

    public function getDateDeNaissance3()
    {
        return $this->getDate(KbisSocieteExtractor::FIELD_DATE_DE_NAISSANCE_3);
    }

    public function getDateDeNaissance4()
    {
        return $this->getDate(KbisSocieteExtractor::FIELD_DATE_DE_NAISSANCE_4);
    }

    public function getDateImmatriculation()
    {
        return $this->getDate(KbisSocieteExtractor::FIELD_DATE_IMMATRICULATION);
    }

    public function getDateImmatriculationOrigine()
    {
        return $this->getDate(KbisSocieteExtractor::FIELD_DATE_IMMATRICULATION_ORIGINE);
    }

    public function getDateMiseAJour()
    {
        return $this->getDate(KbisSocieteExtractor::FIELD_DATE_MISE_A_JOUR);
    }

    public function getDenominationSociale()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_DENOMINATION_SOCIALE);
    }

    public function getDomiciliationEnCommunImmatriculation()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_DOMICILIATION_EN_COMMUN_IMMATRICULATION);
    }

    public function getDomiciliationEnCommunNom()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_DOMICILIATION_EN_COMMUN_NOM);
    }

    public function getDptOuPaysDeNaissance1()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_DPT_OU_PAYS_DE_NAISSANCE_1);
    }

    public function getDptOuPaysDeNaissance2()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_DPT_OU_PAYS_DE_NAISSANCE_2);
    }

    public function getDptOuPaysDeNaissance3()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_DPT_OU_PAYS_DE_NAISSANCE_3);
    }

    public function getDptOuPaysDeNaissance4()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_DPT_OU_PAYS_DE_NAISSANCE_4);
    }

    public function getDureePersonneMorale()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_DUREE_PERSONNE_MORALE);
    }

    public function getFinExtrait()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_FIN_EXTRAIT);
    }

    public function getFonction1()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_FONCTION_1);
    }

    public function getFonction2()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_FONCTION_2);
    }

    public function getFonction3()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_FONCTION_3);
    }

    public function getFonction4()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_FONCTION_4);
    }

    public function getFormeJuridique()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_FORME_JURIDIQUE);
    }

    public function getNationalite1()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_NATIONALITE_1);
    }

    public function getNationalite2()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_NATIONALITE_2);
    }

    public function getNationalite3()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_NATIONALITE_3);
    }

    public function getNationalite4()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_NATIONALITE_4);
    }

    public function getNomPrenoms1()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_NOM_PRENOMS_1);
    }

    public function getNomPrenoms2()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_NOM_PRENOMS_2);
    }

    public function getNomPrenoms3()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_NOM_PRENOMS_3);
    }

    public function getNomPrenoms4()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_NOM_PRENOMS_4);
    }

    public function getNomUsage1()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_NOM_USAGE_1);
    }

    public function getNomUsage2()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_NOM_USAGE_2);
    }

    public function getNomUsage3()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_NOM_USAGE_3);
    }

    public function getNomUsage4()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_NOM_USAGE_4);
    }

    public function getNumeroSiren()
    {
        return str_replace(
            ' ',
            '',
            $this->getData(KbisSocieteExtractor::FIELD_NUMERO_SIREN)
        );
    }

    public function getRcsVille()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_RCS_VILLE);
    }

    public function getSigle()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_SIGLE);
    }

    public function getTransfertRcsVille()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_TRANSFERT_RCS_VILLE);
    }

    public function getVilleDeNaissance1()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_VILLE_DE_NAISSANCE_1);
    }

    public function getVilleDeNaissance2()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_VILLE_DE_NAISSANCE_2);
    }

    public function getVilleDeNaissance3()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_VILLE_DE_NAISSANCE_3);
    }

    public function getVilleDeNaissance4()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_VILLE_DE_NAISSANCE_4);
    }

    public function getVilleDomicilePersonnel1()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_VILLE_DOMICILE_PERSONNEL_1);
    }

    public function getVilleDomicilePersonnel2()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_VILLE_DOMICILE_PERSONNEL_2);
    }

    public function getVilleDomicilePersonnel3()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_VILLE_DOMICILE_PERSONNEL_3);
    }

    public function getVilleDomicilePersonnel4()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_VILLE_DOMICILE_PERSONNEL_4);
    }

    public function getVilleSiege()
    {
        return $this->getData(KbisSocieteExtractor::FIELD_VILLE_SIEGE);
    }
}
