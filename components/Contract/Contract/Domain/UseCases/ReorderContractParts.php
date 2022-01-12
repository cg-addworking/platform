<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\ContractPartOrderIsFirstOneException;
use Components\Contract\Contract\Domain\Exceptions\ContractPartOrderIsLastOneException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;

class ReorderContractParts
{
    private $contractPartRepository;
    private $contractRepository;

    public function __construct(
        ContractPartRepositoryInterface $contractPartRepository,
        ContractRepositoryInterface $contractRepository
    ) {
        $this->contractPartRepository = $contractPartRepository;
        $this->contractRepository = $contractRepository;
    }

    public function handle(User $auth_user, string $direction, ContractPartEntityInterface $contract_part)
    {
        $this->checkUser($auth_user);
        $this->checkContract($contract_part->getContract());

        $this->contractRepository->orderContractParts($contract_part->getContract());
        $contract_part->refresh();

        $this->checkOrderChangingAbility($contract_part, $direction);

        $this->changeOrder($contract_part, $direction);

        return $contract_part->refresh();
    }

    private function changeOrder($contract_part, $direction)
    {
        if ($direction == ContractPartEntityInterface::ORDER_DOWN) {
            $next_contract_part = $this
                ->contractPartRepository
                ->findByOrder($contract_part->getContract(), $contract_part->getOrder() + 1);
            $next_contract_part->setOrder($contract_part->getOrder());
            $this->contractPartRepository->save($next_contract_part);

            $contract_part->setOrder($contract_part->getOrder() + 1);
            $this->contractPartRepository->save($contract_part);
        }

        if ($direction == ContractPartEntityInterface::ORDER_UP) {
            $previous_contract_part = $this
                ->contractPartRepository
                ->findByOrder($contract_part->getContract(), $contract_part->getOrder() - 1);
            $previous_contract_part->setOrder($contract_part->getOrder());
            $this->contractPartRepository->save($previous_contract_part);

            $contract_part->setOrder($contract_part->getOrder() - 1);
            $this->contractPartRepository->save($contract_part);
        }
    }

    private function checkUser(?User $user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }
    }

    private function checkContract(?ContractEntityInterface $contract)
    {
        if (is_null($contract)) {
            throw new ContractIsNotFoundException();
        }
    }

    private function checkOrderChangingAbility(ContractPartEntityInterface $contract_part, string $direction)
    {
        if ($this->contractPartRepository->isOrderedFirst($contract_part, $direction)) {
            throw new ContractPartOrderIsFirstOneException();
        }

        if ($this->contractPartRepository->isOrderedLast($contract_part, $direction)) {
            throw new ContractPartOrderIsLastOneException();
        }
    }
}
