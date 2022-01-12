<?php

namespace App\Repositories\Edenred\Common;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\ProposalResponse;
use App\Models\Edenred\Common\AverageDailyRate;
use App\Models\Edenred\Common\Code;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class AverageDailyRateRepository extends BaseRepository
{
    protected $model = AverageDailyRate::class;
    protected $enterprise;

    public function __construct(EnterpriseRepository $enterprise)
    {
        $this->enterprise = $enterprise;
    }

    public function createFromRequest(Request $request, Code $code): AverageDailyRate
    {
        $average_daily_rate = $this->make($request->input('average_daily_rate'));
        $average_daily_rate->code()->associate($code);
        $average_daily_rate->vendor()->associate($this->enterprise->find($request->input('vendor.id')));
        $average_daily_rate->save();

        return $average_daily_rate;
    }

    public function updateFromRequest(
        Request $request,
        Code $code,
        AverageDailyRate $average_daily_rate
    ): AverageDailyRate {
        $this->update($average_daily_rate, $request->input('average_daily_rate'));

        return $average_daily_rate;
    }

    public function compareAverageDailyRateToUnitPrice(Offer $offer, ProposalResponse $response): bool
    {
        $averageDailyRate = AverageDailyRate::ofCode($offer->edenredCodes()->first())
            ->get()->where('vendor_id', $response->proposal->vendor->id)->first();

        if (! is_null($averageDailyRate)) {
            return $response->unit_price == $averageDailyRate->rate;
        }

        return false;
    }
}
