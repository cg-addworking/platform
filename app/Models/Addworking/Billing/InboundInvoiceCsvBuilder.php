<?php

namespace App\Models\Addworking\Billing;

use Components\Infrastructure\Foundation\Application\CsvBuilder;
use Illuminate\Database\Eloquent\Model;

class InboundInvoiceCsvBuilder extends CsvBuilder
{
    protected $headers = [
        0  => "Prestataire",
        1  => "Numero de facture",
        2  => "Periode facturation",
        3  => "Date de creation",
        4  => "Date de mise a jour",
        5  => "Statut",
        6  => "Echeance de paiement",
        7  => "Montant HT",
        8  => "Montant TTC",
        9  => "(admin) Montant HT",
        10 => "(admin) Montant TVA",
        11 => "(admin) Montant TTC",
        12 => "Lien facture client",
        13 => "Client",
        14 => "Numero de la facture client",
        15 => "Lien facture prestataire",
    ];

    protected function normalize(Model $model): array
    {
        return [
            0  => $model->enterprise->name,
            1  => $model->number,
            2  => $model->month,
            3  => $model->created_at->format('Y-m-d'),
            4  => $model->updated_at->format('Y-m-d'),
            5  => $model->status,
            6  => $model->deadline,
            7  => $model->amount_before_taxes,
            8  => $model->amount_all_taxes_included,
            9  => $model->admin_amount,
            10 => $model->admin_amount_of_taxes,
            11 => $model->admin_amount_all_taxes_included,
            12 => $model->routes->show,
            13 => $model->customer->name,
            14 => $model->outboundInvoice->number,
            15 => $model->outboundInvoice()->exists() ? $model->outboundInvoice->routes->show : "n/a",
        ];
    }
}
