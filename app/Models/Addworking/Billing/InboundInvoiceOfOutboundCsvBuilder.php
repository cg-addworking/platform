<?php

namespace App\Models\Addworking\Billing;

use Components\Infrastructure\Foundation\Application\CsvBuilder;
use Illuminate\Database\Eloquent\Model;

class InboundInvoiceOfOutboundCsvBuilder extends CsvBuilder
{
    protected $headers = [
        0  => "prestataire",
        1  => "siret",
        2  => "facture_date",
        3  => "facture_periode",
        4  => "facture_numero",
        5  => "facture_statut",
        6  => "facture_montant_ht",
        7  => "facture_montant_ttc",
        8  => "mission_numero",
        9  => "mission_objet",
        10 => "mission_date_debut",
        11 => "mission_date_fin",
        12 => "offre_mission_code_analytique",
        13 => "everial_item_mission_referential",
        14 => "periode_date_debut",
        15 => "periode_date_fin",
        16 => "facture_ligne_libelle",
        17 => "facture_ligne_prix_unitaire",
        18 => "facture_ligne_quantite",
        19 => "facture_ligne_montant_ht",
        20 => "facture_ligne_taux_tva",
        21 => "facture_ligne_montant_tva",
        22 => "facture_ligne_montant_ttc",
    ];

    protected function normalize(Model $model): array
    {
        return [
            0  => $model->invoice->enterprise->name,
            1  => $model->invoice->enterprise->identification_number,
            2  => $model->invoice->invoiced_at->format('Y-m-d'),
            3  => $model->invoice->month,
            4  => $model->invoice->number,
            5  => $model->invoice->status,
            6  => $model->invoice->amount_before_taxes,
            7  => $model->invoice->amount_all_taxes_included,
            8  => (isset($model->invoiceable) ? $model->invoiceable->missionTracking->mission->number : null),
            9  => (isset($model->invoiceable) ? $model->invoiceable->missionTracking->mission->label : null),
            10 => (isset($model->invoiceable) ? $model->invoiceable->missionTracking->mission->starts_at : null),
            11 => (isset($model->invoiceable) ? $model->invoiceable->missionTracking->mission->ends_at : null),
            12 => (isset($model->invoiceable)
                ? $model->invoiceable->missionTracking->mission->offer->analytic_code : null),
            13 => (isset($model->invoiceable)
                ? ($model->invoiceable->missionTracking->mission->offer
                    ->everialReferentialMissions()->first()->analytic_code ?? null)
                : null),
            14 => (isset($model->invoiceable) ? $model->invoiceable->missionTracking->milestone->starts_at : null),
            15 => (isset($model->invoiceable) ? $model->invoiceable->missionTracking->milestone->ends_at : null),
            16 => $model->label,
            17 => $model->unit_price,
            18 => $model->quantity,
            19 => $model->getAmountBeforeTaxes(),
            20 => $model->vatRate->value,
            21 => $model->getAmountOfTaxes(),
            22 => $model->getAmountAllTaxesIncluded(),
        ];
    }
}
