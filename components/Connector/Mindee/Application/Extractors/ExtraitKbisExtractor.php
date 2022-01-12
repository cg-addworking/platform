<?php

namespace Components\Connector\Mindee\Application\Extractors;

use Components\Connector\Mindee\Application\Data\ExtraitKbisData;
use Components\Connector\Mindee\Domain\Interfaces\DocumentExtractorInterface;
use Illuminate\Support\Facades\Log;

class ExtraitKbisExtractor extends DocumentExtractor implements DocumentExtractorInterface
{
    const FIELD_ACTIVITES                                 = 'activites';
    const FIELD_ACTIVITES_ETABLISSEMENT                   = 'activites_etablissement';
    const FIELD_ADRESSE_SIEGE                             = 'adresse_siege';
    const FIELD_CAPITAL_SOCIAL                            = 'capital_social';
    const FIELD_CODE_NAF                                  = 'code_naf';
    const FIELD_CODE_POSTAL_SIEGE                         = 'code_postal_siege';
    const FIELD_CODE_VERIFICATION                         = 'code_verification';
    const FIELD_DATE_CLOTURE_EXERCICE_SOCIAL              = 'date_cloture_exercice_social';
    const FIELD_DATE_CLOTURE_PREMIER_EXERCICE_SOCIAL      = 'date_cloture_premier_exercice_social';
    const FIELD_DATE_COMMENCEMENT_ACTIVITE                = 'date_commencement_activite';
    const FIELD_DATE_IMMATRICULATION                      = 'date_immatriculation';
    const FIELD_DATE_IMMATRICULATION_ORIGINE              = 'date_immatriculation_origine';
    const FIELD_DATE_MISE_A_JOUR                          = 'date_mise_a_jour';
    const FIELD_FORME_JURIDIQUE                           = 'forme_juridique';
    const FIELD_DENOMINATION_SOCIALE                      = 'denomination_sociale';
    const FIELD_DOMICILIATION_EN_COMMUN_IMMATRICULATION   = 'domiciliation_en_commun_immatriculation';
    const FIELD_DOMICILIATION_EN_COMMUN_NOM               = 'domiciliation_en_commun_nom';
    const FIELD_DUREE_PERSONNE_MORALE                     = 'duree_personne_morale';
    const FIELD_FIN_EXTRAIT                               = 'fin_extrait';
    const FIELD_NUMERO_SIREN                              = 'numero_siren';
    const FIELD_RCS_VILLE                                 = 'rcs_ville';
    const FIELD_SIGLE                                     = 'sigle';
    const FIELD_TRANSFERT_RCS_VILLE                       = 'transfert_rcs_ville';
    const FIELD_VILLE_SIEGE                               = 'ville_siege';

    public function getData(string $file_content): ExtraitKbisData
    {
        try {
            $sdk_data = [];
            //$sdk_data = json_decode(json_encode($this->client->extraitKbisScan($file_content)->body), true);
            // todo : décommenter quand mindee aura ajouter le code de verification au sdk
            $extrait_kbis_code_de_verification_data = $this->extract($this->client->kbisSocieteScan($file_content));
            $extrait_kbis_data = $extrait_kbis_code_de_verification_data + $sdk_data;
            return new ExtraitKbisData(
                $extrait_kbis_data
            );
        } catch (\Exception $e) {
            Log::error($e);
            Log::info('Document Extractor error : ' . $e->getMessage());
            return new ExtraitKbisData([]);
        }
    }
}
