<?php

namespace App\Repositories\Edenred\Mission;

use App\Models\Addworking\Mission\Offer;
use App\Repositories\Addworking\Mission\OfferRepository as BaseOfferRepository;
use App\Repositories\Edenred\Common\CodeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferRepository extends BaseOfferRepository
{
    protected $code;

    public function __construct(CodeRepository $code)
    {
        $this->code = $code;
    }

    public function createFromRequest(Request $request): Offer
    {
        return DB::transaction(function () use ($request) {
            $code = $this->code->find($request->input('code.id'));

            $offer = parent::createFromRequest($request);
            $offer->update(['label' => "{$code}, {$code->skill->job} - {$code->skill} - Niveau {$code->level}"]);
            $offer->edenredCodes()->attach($code);

            return $offer;
        });
    }
}
