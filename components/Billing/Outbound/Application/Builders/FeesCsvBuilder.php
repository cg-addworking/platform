<?php

namespace Components\Billing\Outbound\Application\Builders;

use Components\Infrastructure\Foundation\Application\CsvBuilder;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\MissionTracking;
use App\Models\Addworking\Mission\MissionTrackingLine;
use Components\Billing\Outbound\Application\Models\Fee;
use Components\Billing\Outbound\Domain\Classes\FeeCsvBuilderInterface;
use Illuminate\Database\Eloquent\Model;

class FeesCsvBuilder extends CsvBuilder implements FeeCsvBuilderInterface
{
    protected $headers = [
        1  => "Numero de ligne de commission",
        2  => "Label de ligne de commission",
        3  => "Type",
        4  => "Montant HT",
        5  => "Taux TVA",
        6  => "Montant",
        7  => "Numéro de facture AddWorking",
        8  => "Numéro de la ligne de facture AddWorking",
        9  => "Prestataire",
        10 => "Code sous-traitant",
        11 => "Reference mission",
        12 => "ID ext du suivi de mission",
        13 => "Description de suivi de mission",
        14 => "Label de ligne suivi de mission",
    ];

    public function normalize(Model $model): array
    {
        return [
            1  => $model->getNumber(),
            2  => remove_accents($model->getLabel()),
            3  => $model->getType(),
            4  => $model->getAmountBeforeTaxes(),
            5  => $model->getVatRate()->display_name,
            6  => $model->getAmountOfTaxes(),
            7  => $model->getOutboundInvoice()->getFormattedNumber(),
            8  => $this->getOutboundInvoiceItemNumber($model),
            9  => $this->getVendorName($model),
            10 => $this->getVendorExternalId($model->getVendor()),
            11 => $this->getReferenceMission($model),
            12 => $this->getMissionTrackingExternalId($this->getMissionTracking($model)),
            13 => $this->getMissionTrackingDescription($this->getMissionTracking($model)),
            14 => $this->getMissionTrackingLineLabel($this->getMissionTracking($model)),
        ];
    }

    private function getOutboundInvoiceItemNumber(Fee $model)
    {
        return $model->getOutboundInvoiceItem() ? $model->getOutboundInvoiceItem()->getNumber() : 'n/a';
    }

    private function getVendorName(Fee $model)
    {
        return $model->getVendor() ? $model->getVendor()->name : 'n/a';
    }

    private function getVendorExternalId($vendor)
    {
        if (! $vendor) {
            return 'n/a';
        }

        if ($vendor->isVendorOfSogetrel()) {
            return $vendor->sogetrelData->navibat_id ?? 'n/a';
        }

        return $vendor->external_id;
    }

    private function getReferenceMission(Fee $model)
    {
        return (isset($model->outboundInvoiceItem->inboundInvoiceItem->invoiceable)
            ? $model->outboundInvoiceItem->inboundInvoiceItem->invoiceable->missionTracking->mission->number
            : 'n/a');
    }

    private function getMissionTracking(Fee $model)
    {
        return (isset($model->outboundInvoiceItem->inboundInvoiceItem->invoiceable)
            ? $model->outboundInvoiceItem->inboundInvoiceItem->invoiceable->missionTracking
            : 'n/a');
    }

    private function getMissionTrackingExternalId($mission_tracking)
    {
        return ($mission_tracking instanceof MissionTracking) ? $mission_tracking->external_id : 'n/a';
    }

    private function getMissionTrackingDescription($mission_tracking)
    {
        return ($mission_tracking instanceof MissionTracking) ? $mission_tracking->description : 'n/a';
    }

    private function getMissionTrackingLineLabel($mission_tracking)
    {
        return ($mission_tracking instanceof MissionTracking)
            ? $mission_tracking->trackingLines()->pluck('label')->join(',') : 'n/a';
    }
}
