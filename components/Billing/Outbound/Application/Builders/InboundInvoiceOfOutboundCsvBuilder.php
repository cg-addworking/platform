<?php

namespace Components\Billing\Outbound\Application\Builders;

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
        13 => "item_mission_referential",
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
            0  => $model->getInboundInvoice()->enterprise->name,
            1  => $model->getInboundInvoice()->enterprise->identification_number,
            2  => $model->getInboundInvoice()->invoiced_at->format('Y-m-d'),
            3  => $model->getInboundInvoice()->month,
            4  => $model->getInboundInvoice()->number,
            5  => $model->getInboundInvoice()->status,
            6  => $model->getInboundInvoice()->amount_before_taxes,
            7  => $model->getInboundInvoice()->amount_all_taxes_included,
            8  => (isset($model->getInboundInvoiceItem()->invoiceable)
                ? $model->getInboundInvoiceItem()->invoiceable->missionTracking->mission->number : null),
            9  => (isset($model->getInboundInvoiceItem()->invoiceable)
                ? $model->getInboundInvoiceItem()->invoiceable->missionTracking->mission->label : null),
            10 => (isset($model->getInboundInvoiceItem()->invoiceable)
                ? $model->getInboundInvoiceItem()->invoiceable->missionTracking->mission->starts_at : null),
            11 => (isset($model->getInboundInvoiceItem()->invoiceable)
                ? $model->getInboundInvoiceItem()->invoiceable->missionTracking->mission->ends_at : null),
            12 => (isset($model->getInboundInvoiceItem()->invoiceable)
                ? $model->getInboundInvoiceItem()->invoiceable->missionTracking->mission->offer->analytic_code : null),
            13 => (isset($model->getInboundInvoiceItem()->invoiceable)
                ? ($model->getInboundInvoiceItem()->invoiceable->missionTracking->mission->offer
                    ->everialReferentialMissions()->first()->analytic_code ?? null)
                : null),
            14 => (isset($model->getInboundInvoiceItem()->invoiceable)
                ? $model->getInboundInvoiceItem()->invoiceable->missionTracking->milestone->starts_at : null),
            15 => (isset($model->getInboundInvoiceItem()->invoiceable)
                ? $model->getInboundInvoiceItem()->invoiceable->missionTracking->milestone->ends_at : null),
            16 => $model->getLabel(),
            17 => $model->getUnitPrice(),
            18 => $model->getQuantity(),
            19 => $model->getAmountBeforeTaxes(),
            20 => $model->getVatRate()->value,
            21 => $model->getAmountOfTaxes(),
            22 => $model->getAmountAllTaxesIncluded(),
        ];
    }
}
