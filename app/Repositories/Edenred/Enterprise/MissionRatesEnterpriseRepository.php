<?php

namespace App\Repositories\Edenred\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Offer;

class MissionRatesEnterpriseRepository
{
    public function hasRateForOffer(Enterprise $enterprise, Offer $offer): bool
    {
        return $enterprise->averageDailyRates()
            ->whereHas('code', fn($q) => $q->whereIn('id', $offer->edenredCodes()->pluck('id')))
            ->exists();
    }
}
