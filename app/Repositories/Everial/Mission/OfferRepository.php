<?php

namespace App\Repositories\Everial\Mission;

use App\Repositories\Addworking\Mission\OfferRepository as BaseOfferRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Addworking\Mission\Offer;

class OfferRepository extends BaseOfferRepository
{
    protected $referential;

    public function __construct(ReferentialRepository $referential)
    {
        $this->referential = $referential;
    }

    public function createFromRequest(Request $request): Offer
    {
        return DB::transaction(function () use ($request) {
            $referential = $this->referential->find($request->input('referential.id'));

            $offer = parent::createFromRequest($request);
            $offer->everialReferentialMissions()->attach($referential);

            return $offer;
        });
    }

    public function updateFromRequest(Offer $offer, Request $request): Offer
    {
        return DB::transaction(function () use ($request, $offer) {
            $referential = $this->referential->find($request->input('referential.id'));

            $offer = parent::updateFromRequest($offer, $request);
            $offer->everialReferentialMissions()->sync($referential);

            return $offer;
        });
    }
}
