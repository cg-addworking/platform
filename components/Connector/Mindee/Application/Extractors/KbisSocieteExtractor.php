<?php

namespace Components\Connector\Mindee\Application\Extractors;

use Components\Connector\Mindee\Application\Data\KbisSocieteData;
use Components\Connector\Mindee\Domain\Interfaces\DocumentExtractorInterface;

class KbisSocieteExtractor extends DocumentExtractor implements DocumentExtractorInterface
{
    const FIELD_ACTIVITES                                 = 'activites';
    const FIELD_ACTIVITES_ETABLISSEMENT                   = 'activites_etablissement';
    const FIELD_ADRESSE_DOMICILE_PERSONNEL_1              = 'adresse_domicile_personnel_1';
    const FIELD_ADRESSE_DOMICILE_PERSONNEL_2              = 'adresse_domicile_personnel_2';
    const FIELD_ADRESSE_DOMICILE_PERSONNEL_3              = 'adresse_domicile_personnel_3';
    const FIELD_ADRESSE_DOMICILE_PERSONNEL_4              = 'adresse_domicile_personnel_4';
    const FIELD_ADRESSE_SIEGE                             = 'adresse_siege';
    const FIELD_CAPITAL_SOCIAL                            = 'capital_social';
    const FIELD_CODE_NAF                                  = 'code_naf';
    const FIELD_CODE_POSTAL_DOMICILE_PERSONNEL_1          = 'code_postal_domicile_personnel_1';
    const FIELD_CODE_POSTAL_DOMICILE_PERSONNEL_2          = 'code_postal_domicile_personnel_2';
    const FIELD_CODE_POSTAL_DOMICILE_PERSONNEL_3          = 'code_postal_domicile_personnel_3';
    const FIELD_CODE_POSTAL_DOMICILE_PERSONNEL_4          = 'code_postal_domicile_personnel_4';
    const FIELD_CODE_POSTAL_SIEGE                         = 'code_postal_siege';
    const FIELD_CODE_VERIFICATION                         = 'code_verification';
    const FIELD_DATE_CLOTURE_EXERCICE_SOCIAL              = 'date_cloture_exercice_social';
    const FIELD_DATE_CLOTURE_PREMIER_EXERCICE_SOCIAL      = 'date_cloture_premier_exercice_social';
    const FIELD_DATE_COMMENCEMENT_ACTIVITE                = 'date_commencement_activite';
    const FIELD_DATE_DE_NAISSANCE_1                       = 'date_de_naissance_1';
    const FIELD_DATE_DE_NAISSANCE_2                       = 'date_de_naissance_2';
    const FIELD_DATE_DE_NAISSANCE_3                       = 'date_de_naissance_3';
    const FIELD_DATE_DE_NAISSANCE_4                       = 'date_de_naissance_4';
    const FIELD_DATE_IMMATRICULATION                      = 'date_immatriculation';
    const FIELD_DATE_IMMATRICULATION_ORIGINE              = 'date_immatriculation_origine';
    const FIELD_DATE_MISE_A_JOUR                          = 'date_mise_a_jour';
    const FIELD_DENOMINATION_SOCIALE                      = 'denomination_sociale';
    const FIELD_DOMICILIATION_EN_COMMUN_IMMATRICULATION   = 'domiciliation_en_commun_immatriculation';
    const FIELD_DOMICILIATION_EN_COMMUN_NOM               = 'domiciliation_en_commun_nom';
    const FIELD_DPT_OU_PAYS_DE_NAISSANCE_1                = 'dpt_ou_pays_de_naissance_1';
    const FIELD_DPT_OU_PAYS_DE_NAISSANCE_2                = 'dpt_ou_pays_de_naissance_2';
    const FIELD_DPT_OU_PAYS_DE_NAISSANCE_3                = 'dpt_ou_pays_de_naissance_3';
    const FIELD_DPT_OU_PAYS_DE_NAISSANCE_4                = 'dpt_ou_pays_de_naissance_4';
    const FIELD_DUREE_PERSONNE_MORALE                     = 'duree_personne_morale';
    const FIELD_FIN_EXTRAIT                               = 'fin_extrait';
    const FIELD_FONCTION_1                                = 'fonction_1';
    const FIELD_FONCTION_2                                = 'fonction_2';
    const FIELD_FONCTION_3                                = 'fonction_3';
    const FIELD_FONCTION_4                                = 'fonction_4';
    const FIELD_FORME_JURIDIQUE                           = 'forme_juridique';
    const FIELD_NATIONALITE_1                             = 'nationalite_1';
    const FIELD_NATIONALITE_2                             = 'nationalite_2';
    const FIELD_NATIONALITE_3                             = 'nationalite_3';
    const FIELD_NATIONALITE_4                             = 'nationalite_4';
    const FIELD_NOM_PRENOMS_1                             = 'nom_prenoms_1';
    const FIELD_NOM_PRENOMS_2                             = 'nom_prenoms_2';
    const FIELD_NOM_PRENOMS_3                             = 'nom_prenoms_3';
    const FIELD_NOM_PRENOMS_4                             = 'nom_prenoms_4';
    const FIELD_NOM_USAGE_1                               = 'nom_usage_1';
    const FIELD_NOM_USAGE_2                               = 'nom_usage_2';
    const FIELD_NOM_USAGE_3                               = 'nom_usage_3';
    const FIELD_NOM_USAGE_4                               = 'nom_usage_4';
    const FIELD_NUMERO_SIREN                              = 'numero_siren';
    const FIELD_RCS_VILLE                                 = 'rcs_ville';
    const FIELD_SIGLE                                     = 'sigle';
    const FIELD_TRANSFERT_RCS_VILLE                       = 'transfert_rcs_ville';
    const FIELD_VILLE_DE_NAISSANCE_1                      = 'ville_de_naissance_1';
    const FIELD_VILLE_DE_NAISSANCE_2                      = 'ville_de_naissance_2';
    const FIELD_VILLE_DE_NAISSANCE_3                      = 'ville_de_naissance_3';
    const FIELD_VILLE_DE_NAISSANCE_4                      = 'ville_de_naissance_4';
    const FIELD_VILLE_DOMICILE_PERSONNEL_1                = 'ville_domicile_personnel_1';
    const FIELD_VILLE_DOMICILE_PERSONNEL_2                = 'ville_domicile_personnel_2';
    const FIELD_VILLE_DOMICILE_PERSONNEL_3                = 'ville_domicile_personnel_3';
    const FIELD_VILLE_DOMICILE_PERSONNEL_4                = 'ville_domicile_personnel_4';
    const FIELD_VILLE_SIEGE                               = 'ville_siege';

    public function getData(string $file_content): KbisSocieteData
    {
        return new KbisSocieteData($this->extract($this->client->kbisSocieteScan($file_content)));
    }
}
