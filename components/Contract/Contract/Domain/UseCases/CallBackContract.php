<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractInvalidStateException;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotGenerateException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportOrCreatorException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;

class CallBackContract
{
    private $userRepository;
    private $contractRepository;
    private $contractStateRepository;
    private $contractPartRepository;
    private $contractPartyRepository;

    public function __construct(
        UserRepository $userRepository,
        ContractRepository $contractRepository,
        ContractStateRepository $contractStateRepository,
        ContractPartRepository $contractPartRepository,
        ContractPartyRepository $contractPartyRepository
    ) {
        $this->userRepository = $userRepository;
        $this->contractRepository = $contractRepository;
        $this->contractStateRepository = $contractStateRepository;
        $this->contractPartRepository = $contractPartRepository;
        $this->contractPartyRepository = $contractPartyRepository;
    }

    public function handle(User $user, Contract $contract)
    {
        $this->checkContract($contract);
        $this->checkUser($user, $contract);

        foreach ($contract->getParts() as $part) {
            $part->setYousignFileId(null);
            $this->contractPartRepository->save($part);
        }

        foreach ($contract->getParties() as $party) {
            $party->setYousignMemberId(null);
            $party->setYousignFileObjectId(null);
            $party->setSignedAt(null);
            $party->setValidatedAt(null);
            if (! is_null($party->getDeclinedAt())) {
                $party->setDeclinedAt(null);
            }

            $this->contractPartyRepository->save($party);
        }

        $contract->setYousignProcedureId(null);
        $contract->setSentToSignatureAt(null);
        $contract->setSentToSignatureBy(null);
        $contract->setNextPartyToSign(null);
        $contract->setNextPartyToValidate(null);
        $this->contractRepository->save($contract);
        
        $this->contractStateRepository->updateContractState($contract);
        
        return $contract;
    }

    private function checkUser($user, $contract)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if ($this->userRepository->isSupport($user)) {
            return true;
        }

        if (!$this->contractRepository->isOwnerOf($user, $contract)) {
            throw new UserIsNotSupportOrCreatorException;
        }
    }

    private function checkContract($contract)
    {
        if (is_null($contract)) {
            throw new ContractIsNotFoundException;
        }

        if (is_null($contract->getYousignProcedureId())) {
            throw new ContractIsNotGenerateException;
        }

        if (!in_array(
            $contract->getState(),
            [
                ContractEntityInterface::STATE_TO_VALIDATE,
                ContractEntityInterface::STATE_TO_SIGN,
                ContractEntityInterface::STATE_DECLINED
            ]
        )) {
            throw new ContractInvalidStateException;
        }
    }
}
