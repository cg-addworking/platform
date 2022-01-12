<?php

namespace Components\Contract\Contract\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Contract\Application\Jobs\GenerateContractPartsForSogetrelJob;
use Components\Contract\Contract\Application\Jobs\GenerateContractPartsJob;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractPart;
use Components\Contract\Contract\Application\Repositories\AnnexRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Application\Requests\StoreContractPartRequest;
use Components\Contract\Contract\Domain\UseCases\AddContractPartToSignedContract;
use Components\Contract\Contract\Domain\UseCases\AssociateAnnexToContract;
use Components\Contract\Contract\Domain\UseCases\CreateContractPart;
use Components\Contract\Contract\Domain\UseCases\DeleteContractPart;
use Components\Contract\Contract\Domain\UseCases\ListAnnexAsSupport;
use Components\Contract\Contract\Domain\UseCases\ReorderContractParts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ContractPartController extends Controller
{
    protected $userRepository;
    protected $contractPartRepository;
    protected $contractRepository;
    protected $annexRepository;

    public function __construct(
        UserRepository $userRepository,
        ContractPartRepository $contractPartRepository,
        ContractRepository $contractRepository,
        AnnexRepository $annexRepository
    ) {
        $this->userRepository = $userRepository;
        $this->contractPartRepository = $contractPartRepository;
        $this->contractRepository = $contractRepository;
        $this->annexRepository = $annexRepository;
    }

    public function create(Contract $contract)
    {
        $this->authorize('create', [ContractPart::class, $contract]);

        $contract_part = $this->contractPartRepository->make();
        
        return view('contract::contract_part.create', compact('contract', 'contract_part'));
    }

    public function store(Contract $contract, StoreContractPartRequest $request)
    {
        $this->authorize('store', [ContractPart::class, $contract]);

        if (! is_null($request->input('contract_part.is_from_annexes')) &&
            $request->input('contract_part.is_from_annexes') == '1'
        ) {
            $annex = $this->annexRepository->findById($request->input('contract_part.annex_id'));
            $part = App::make(AssociateAnnexToContract::class)->handle(
                $this->userRepository->connectedUser(),
                $annex,
                $contract,
                $request->input('contract_part'),
            );
        } else {
            $part = App::make(CreateContractPart::class)->handle(
                $this->userRepository->connectedUser(),
                $contract,
                $request->input('contract_part'),
                $request->file('contract_part.file')
            );
        }

        return $this->redirectWhen($part->exists, route('contract.show', $contract));
    }


    public function createSignedContractPart(Contract $contract)
    {
        $this->authorize('createSignedContractPart', [ContractPart::class, $contract]);

        $contract_part = $this->contractPartRepository->make();

        return view('contract::contract_part.signed_contract.create', compact('contract', 'contract_part'));
    }

    public function storeSignedContractPart(Contract $contract, Request $request)
    {
        $this->authorize('storeSignedContractPart', [ContractPart::class, $contract]);

        $part = App::make(AddContractPartToSignedContract::class)->handle(
            $this->userRepository->connectedUser(),
            $contract,
            $request->input('contract_part'),
            $request->file('contract_part.file')
        );

        return $this->redirectWhen($part->exists, route('contract.show', $contract));
    }

    public function delete(Contract $contract, ContractPart $contract_part)
    {
        $this->authorize('delete', $contract_part);

        $deleted = App::make(DeleteContractPart::class)
            ->handle($this->userRepository->connectedUser(), $contract_part);

        return $this->redirectWhen($deleted, route('contract.show', $contract));
    }

    public function order(Contract $contract, ContractPart $contract_part, Request $request)
    {
        $this->authorize('orderParts', $contract);

        $part = App::make(ReorderContractParts::class)->handle(
            $this->userRepository->connectedUser(),
            $request->input('direction'),
            $contract_part
        );

        return $this->redirectWhen($part->exists, route('contract.show', $contract));
    }

    public function regenerate(Contract $contract, Request $request)
    {
        $this->authorize('regenerate', [ContractPart::class, $contract]);

        // todo: temporary solution to isolate generation of sogetrel contracts
        $sogetrel = Enterprise::where('name', 'SOGETREL')->first();
        $sogetrelFamily = App::make(EnterpriseRepository::class)->getDescendants($sogetrel, true);

        if ($sogetrelFamily->contains($contract->getEnterprise())) {
            GenerateContractPartsForSogetrelJob::dispatch($request->user(), $contract);
        } else {
            GenerateContractPartsJob::dispatchSync($request->user(), $contract);
        }

        return $this->redirectWhen(true, route('contract.show', $contract));
    }
}
