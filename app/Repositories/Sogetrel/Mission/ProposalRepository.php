<?php

namespace App\Repositories\Sogetrel\Mission;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Sogetrel\User\Passwork;
use App\Notifications\Mission\Proposal\Send;
use App\Repositories\Addworking\Mission\OfferRepository;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ProposalRepository extends BaseRepository
{
    protected $model = Proposal::class;
    protected $offer;

    public function __construct(OfferRepository $offer)
    {
        $this->offer = $offer;
    }

    public function createFromRequestForAllSelection(Request $request, Offer $offer): Collection
    {
        return DB::transaction(function () use ($request, $offer) {
            $proposals = new Collection;
            $passworks = Passwork::search($request)->get();

            foreach ($passworks as $passwork) {
                $proposal = $this->make(['label' => $offer->label, 'valid_from' => Carbon::now()]);
                $proposal->vendor()->associate($passwork->user->enterprise->id);
                $proposal->createdBy()->associate($request->user());
                $proposal->offer()->associate($offer);
                $proposal->save();

                Notification::send($proposal->vendor->users, new Send($proposal));
                $proposals->push($proposal);
            }

            $offer->update(['status' => Offer::STATUS_COMMUNICATED]);
            return $proposals;
        });
    }

    public function createBpuFromRequest(Request $request, Proposal $proposal): Proposal
    {
        return DB::transaction(function () use ($request, $proposal) {
            $file = File::from($request->file('bpu_file'))
                ->name("/bpu-%uniq%-%ts%.%ext%")
                ->saveAndGet();
            $proposal->file()->associate($file)->save();
            $proposal->update(['status' => Proposal::STATUS_BPU_SENDED]);
            return $proposal;
        });
    }
}
