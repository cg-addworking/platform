<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractValidatorEditFailedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportOrCreatorException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class EditContractValidators
{
    private $contractRepository;
    private $userRepository;

    public function __construct(
        ContractRepositoryInterface $contractRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->contractRepository = $contractRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $auth_user
     * @param ContractEntityInterface $contract
     * @param array $inputs
     * @return mixed
     * @throws ContractValidatorEditFailedException
     * @throws UserIsNotAuthenticatedException
     * @throws UserIsNotSupportOrCreatorException
     */
    public function handle(User $auth_user, ContractEntityInterface $contract, ?array $inputs)
    {
        $this->checkUser($auth_user, $contract);
        $this->checkContract($contract);

        $this->updateContractValidator($contract, $inputs);

        return $this->contractRepository->save($contract);
    }

    /**
     * @param ContractEntityInterface $contract
     * @param array $inputs
     * @return ContractEntityInterface
     */
    private function updateContractValidator(ContractEntityInterface $contract, ?array $inputs)
    {
        // first we delete contract validator
        DB::transaction(function () use ($inputs, $contract) {
            $this->deleteContractValidator($contract);

            $contract_parties_signatory_ids = $contract->getParties()->pluck('signatory.id')->toArray();

            if (! is_null($inputs)) {
                foreach ($inputs as $order => $validator_id) {
                    if (! in_array($validator_id, $contract_parties_signatory_ids)) {
                        $signatory = $this->userRepository->find($validator_id);
                        $contract_party = App::make(ContractPartyRepository::class)->make();
                        $contract_party->setContract($contract);
                        $contract_party->setEnterprise($contract->getEnterprise());
                        $contract_party->setEnterpriseName($contract->getEnterprise()->name);
                        $contract_party->setSignatory($signatory);
                        $contract_party->setSignatoryName($signatory->name);
                        $contract_party->setOrder($order);
                        $contract_party->setIsValidator(true);
                        $contract_party->setDenomination('Validator ' . $order);
                        $contract_party->setNumber();
                        App::make(ContractPartyRepository::class)->save($contract_party);
                    }
                }
            }
        });

        return $contract;
    }

    /**
     * @param User $user
     * @param Contract $contract
     * @throws UserIsNotAuthenticatedException
     * @throws UserIsNotSupportOrCreatorException
     */
    private function checkUser(User $user, Contract $contract)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (! $this->userRepository->isSupport($user) && ! $this->contractRepository->isCreator($user, $contract)) {
            throw new UserIsNotSupportOrCreatorException();
        }
    }

    /**
     * @param Contract $contract
     * @throws ContractValidatorEditFailedException
     */
    private function checkContract(Contract $contract)
    {
        if (! in_array($contract->getState(), [
            ContractEntityInterface::STATE_MISSING_DOCUMENTS,
            ContractEntityInterface::STATE_IN_PREPARATION,
            ContractEntityInterface::STATE_DRAFT,
            ContractEntityInterface::STATE_GENERATED
        ])
        ) {
            throw new ContractValidatorEditFailedException();
        }
    }

    /**
     * @param Contract $contract
     */
    private function deleteContractValidator(Contract $contract)
    {
        $contract_validators = $this->contractRepository->getValidatorParties($contract);

        foreach ($contract_validators as $validator) {
            $validator->delete();
        }
    }
}
