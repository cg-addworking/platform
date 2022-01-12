<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotMemberOfTheContractEnterpriseException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;

class IdentifyValidator
{
    private $contractPartyRepository;
    private $userRepository;

    public function __construct(
        ContractPartyRepositoryInterface $contractPartyRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->contractPartyRepository = $contractPartyRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(User $auth_user, ContractEntityInterface $contract, int $order, $validator_id)
    {
        $this->checkUser($auth_user, $contract);

        $contract_parties_signatory_ids = $contract->getParties()->pluck('signatory.id')->toArray();

        if (!in_array($validator_id, $contract_parties_signatory_ids)) {
            $signatory = $this->userRepository->find($validator_id);
            $this->checkUserEnterprise($signatory, $contract);
            $contract_party = $this->contractPartyRepository->make();
            $contract_party->setContract($contract);
            $contract_party->setEnterprise($contract->getEnterprise());
            $contract_party->setEnterpriseName($contract->getEnterprise()->name);
            $contract_party->setSignatory($signatory);
            $contract_party->setSignatoryName($signatory->name);
            $contract_party->setOrder($order);
            $contract_party->setIsValidator(true);
            $contract_party->setDenomination('Validator ' . $order);
            $contract_party->setNumber();
            return $this->contractPartyRepository->save($contract_party);
        }
        return false;
    }

    private function checkUser($user, $contract)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if ($this->userRepository->isSupport($user)) {
            return true;
        }

        if (! $user->enterprises->contains($contract->getEnterprise())) {
            throw new UserIsNotMemberOfTheContractEnterpriseException();
        }

        return true;
    }

    public function checkUserEnterprise($user, $contract)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (! $user->enterprises->contains($contract->getEnterprise())) {
            throw new UserIsNotMemberOfTheContractEnterpriseException();
        }
    }
}
