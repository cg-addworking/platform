<?php

namespace Components\Contract\Contract\Application\Controllers;

use App\Http\Controllers\Controller;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\MissionRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Application\Requests\StoreContractMissionRequest;
use Components\Contract\Contract\Domain\UseCases\LinkContractAndMission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ContractMissionController extends Controller
{
    private $contractRepository;
    private $missionRepository;
    private $userRepository;

    public function __construct(
        ContractRepository $contractRepository,
        MissionRepository $missionRepository,
        UserRepository $userRepository
    ) {
        $this->contractRepository = $contractRepository;
        $this->missionRepository = $missionRepository;
        $this->userRepository = $userRepository;
    }

    public function create(Request $request)
    {
        $contract = $mission = null;
        $contracts = $missions = [];

        if ($request->has('contract')) {
            $contract = $this->contractRepository->find($request->query('contract'));

            $this->authorize('linkContractToMission', $contract);

            $customer = $contract->getParties()->filter(function ($party) {
                return $party->getEnterprise()->isCustomer();
            })->first()->getEnterprise();

            $vendor = $contract->getParties()->filter(function ($party) {
                return $party->getEnterprise()->isVendor();
            })->first()->getEnterprise();

            $missions = $this
                ->missionRepository
                ->getMissionsBetween($customer, $vendor)
                ->pluck('label', 'id');

            $contracts = [
                $contract->getId() => $contract->getName()
            ];
        }

        if ($request->has('mission')) {
            $mission = $this->missionRepository->find($request->query('mission'));

            $this->authorize('linkMissionToContract', $mission);

            $partners = $this->missionRepository->getPartners($mission);

            $contracts = $this
                ->contractRepository
                ->getContractsBetween($partners, true)
                ->pluck('name', 'id');

            $missions = [
                $mission->id => $mission->label,
            ];
        }

        return view('contract::contract_mission.create', compact('contract', 'mission', 'contracts', 'missions'));
    }

    public function store(StoreContractMissionRequest $request)
    {
        $contract = $this->contractRepository->find($request->input('contract_id'));
        $mission = $this->missionRepository->find($request->input('mission_id'));

        $linked = App::make(LinkContractAndMission::class)->handle(
            $this->userRepository->connectedUser(),
            $contract,
            $mission
        );

        if ($request->input('origin') == 'contract') {
            $route = route('contract.show', $contract);
        }

        if ($request->input('origin') == 'mission') {
            if (! is_null($mission->getReferent())) {
                $route = route('sector.mission.show', $mission);
            } else {
                $route = route('mission.show', $mission);
            }
        }

        return $this->redirectWhen($linked, $route);
    }
}
