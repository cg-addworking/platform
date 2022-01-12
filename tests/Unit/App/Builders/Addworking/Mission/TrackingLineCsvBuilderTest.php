<?php

namespace Tests\Unit\App\Builders\Addworking\Mission;

use App\Builders\Addworking\Mission\TrackingLineCsvBuilder;
use App\Models\Addworking\Mission\MissionTrackingLine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackingLineCsvBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function testNormalize()
    {
        $lines = factory(MissionTrackingLine::class, 10)->create();
        $headers = ['customer', 'vendor', 'numero mission', 'objet mission', 'date debut mission',
        'date fin de mission', 'milestone du suivi', 'libelle ligne de suivi', 'PUHT', 'quantite',
        'statut validation customer', 'statut validation vendor', 'numero facture inbound',
        'statut facture inbound', 'code analytique offre de mission', 'code analytique item referentiel mission'];

        $builder = new TrackingLineCsvBuilder();
        $builder->addAll($lines);
        $handle = fopen($builder->getPathname(), 'r');

        $this->assertEquals($headers, fgetcsv($handle, 0, ';'));

        foreach ($lines as $line) {
            $this->assertEquals([
                $line->missionTracking->mission->customer,
                $line->missionTracking->mission->vendor,
                $line->missionTracking->mission->number,
                $line->missionTracking->mission->label,
                $line->missionTracking->mission->starts_at,
                $line->missionTracking->mission->ends_at,
                $line->missionTracking->milestone->id,
                $line->label,
                $line->unit_price,
                $line->quantity,
                $line->validation_customer,
                $line->validation_vendor,
                $line->missionTracking->mission->inboundInvoiceItem->inboundInvoice->number,
                $line->missionTracking->mission->inboundInvoiceItem->inboundInvoice->status,
                $line->missionTracking->mission->offer->analytic_code,
                TrackingLineCsvBuilder::getEverialReferentialCodes($line),
            ], fgetcsv($handle, 0, ';'));
        }
    }
}
