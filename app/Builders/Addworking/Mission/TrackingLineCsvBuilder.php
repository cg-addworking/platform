<?php

namespace App\Builders\Addworking\Mission;

use App\Models\Addworking\Mission\MissionTrackingLine;
use Components\Infrastructure\Foundation\Application\CsvBuilder;
use Illuminate\Database\Eloquent\Model;

class TrackingLineCsvBuilder extends CsvBuilder
{
    protected $headers = [
        1  => 'customer',
        2  => 'vendor',
        3  => 'numero mission',
        4  => 'objet mission',
        5  => 'date debut mission',
        6  => 'date fin de mission',
        7  => 'milestone du suivi',
        8  => 'libelle ligne de suivi',
        9  => 'PUHT',
        10 => 'quantite',
        11 => 'statut validation customer',
        12 => 'statut validation vendor',
        13 => 'numero facture inbound',
        14 => 'statut facture inbound',
        15 => 'code analytique offre de mission',
        16 => 'code analytique item referentiel mission',
    ];

    protected function normalize(Model $model): array
    {
        $data = [];
        $missionTracking = $model->getMissionTracking();
            $data += [
                1  => $missionTracking ? $missionTracking->mission->customer : null,
                2  => $missionTracking ? $missionTracking->mission->vendor : null,
                3  => $missionTracking ? $missionTracking->mission->number : null,
                4  => $missionTracking ? $missionTracking->mission->label : null,
                5  => $missionTracking ? $missionTracking->mission->starts_at : null,
                6  => $missionTracking ? $missionTracking->mission->ends_at : null,
                7  => $missionTracking ? $missionTracking->milestone->id : null,
                8  => $model->label,
                9  => $model->unit_price,
                10 => $model->quantity,
                11 => $model->validation_customer,
                12 => $model->validation_vendor,
                13 => $missionTracking ? $missionTracking->mission->inboundInvoiceItem->inboundInvoice->number : null,
                14 => $missionTracking ? $missionTracking->mission->inboundInvoiceItem->inboundInvoice->status : null,
                15 => $missionTracking ? $missionTracking->mission->offer->analytic_code : null,
                16 => $missionTracking ? $this->getEverialReferentialCodes($model) : null,
            ];
            return $data;
    }

    public static function getEverialReferentialCodes(MissionTrackingLine $line): string
    {
        return $line->missionTracking->mission->offer->everialReferentialMissions
            ->pluck('analytic_code')->filter()->unique()->sort()->join(", ");
    }
}
