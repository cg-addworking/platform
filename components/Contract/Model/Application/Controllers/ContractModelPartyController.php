<?php

namespace Components\Contract\Model\Application\Controllers;

use App\Http\Controllers\Controller;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Models\ContractModelParty;
use Components\Contract\Model\Application\Repositories\UserRepository;
use Components\Contract\Model\Domain\UseCases\DeleteContractModelParty;
use Illuminate\Support\Facades\App;

class ContractModelPartyController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function delete(ContractModel $contract_model, ContractModelParty $contract_model_party)
    {
        $this->authorize('delete', [$contract_model_party, $contract_model]);

        $deleted = App::make(DeleteContractModelParty::class)
            ->handle($this->userRepository->connectedUser(), $contract_model_party);

        return $this->redirectWhen(
            $deleted,
            route('support.contract.model.show', $contract_model)
        );
    }
}
