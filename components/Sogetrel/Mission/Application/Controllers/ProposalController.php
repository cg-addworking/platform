<?php

namespace Components\Sogetrel\Mission\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmationBpu;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\Proposal;
use App\Repositories\Sogetrel\Mission\ProposalRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProposalController extends Controller
{
    protected $repository;

    public function __construct(ProposalRepository $repository)
    {
        $this->repository = $repository;
    }

    public function storeAll(Request $request, Offer $offer)
    {
        $proposals = $this->repository->createFromRequestForAllSelection($request, $offer);

        return redirect_when(count($proposals), $offer->routes->show);
    }

    public function create(Offer $offer)
    {
        $this->authorize('create', Proposal::class);

        $proposal = new Proposal;
        return view($this->views['create'] ?? 'sogetrel.mission.proposal.create', @compact('proposal', 'offer'));
    }

    public function createBpu(Proposal $proposal)
    {
        return view('sogetrel.mission.proposal.bpu.create', @compact('proposal'));
    }

    public function storeBpu(Request $request, Proposal $proposal)
    {
        $this->authorize('storeBpu', $proposal);

        if (isset($proposal->file)) {
            $proposal->file->delete();
        }

        $proposal = $this->repository->createBpuFromRequest($request, $proposal);
        $users = $proposal->vendor->users;
        $mail = new ConfirmationBpu($proposal);
        Mail::to($users)->send($mail);
        return redirect_when($proposal->exists, $proposal->routes->show);
    }
}
