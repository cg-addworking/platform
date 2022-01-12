<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Domain\Exceptions\ContractInvalidStateException;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Infrastructure\ElectronicSignature\Application\Yousign\Client;

class UpdateContractFromYousignData
{
    private $contractRepository;
    private $userRepository;
    private $contractPartRepository;
    private $contractPartyRepository;

    public function __construct(
        ContractRepositoryInterface $contractRepository,
        UserRepositoryInterface $userRepository,
        ContractPartRepositoryInterface $contractPartRepository,
        ContractPartyRepositoryInterface $contractPartyRepository
    ) {
        $this->contractRepository = $contractRepository;
        $this->userRepository = $userRepository;
        $this->contractPartRepository = $contractPartRepository;
        $this->contractPartyRepository = $contractPartyRepository;
    }

    public function handle(User $auth_user, ContractEntityInterface $contract)
    {
        $this->check($auth_user, $contract);

        $yousign_client = new Client();
        $yousign_data = $yousign_client->getProcedureData($contract->getYousignProcedureId());
        $this->updateParties($contract, $yousign_data->body->members);
        $this->updateContractParts($yousign_client, $contract);

        $next_party_to_validate = $this->contractPartyRepository
            ->getNextPartyThatShouldValidate($contract);
        if (isset($next_party_to_validate)) {
            $contract->setNextPartyToValidate($next_party_to_validate);
        }

        $next_party_to_sign = $this->contractPartyRepository->getNextPartyThatShouldSign($contract);
        if (isset($next_party_to_sign)) {
            $contract->setNextPartyToSign($next_party_to_sign);
        }
        $this->contractRepository->save($contract);

        return $contract;
    }

    private function updateContractParts($yousign_client, ContractEntityInterface $contract)
    {
        foreach ($contract->getParts() as $part) {
            if (! is_null($part->getYousignFileId())) {
                $content = $yousign_client->downloadFile($part->getYousignFileId());
                $file = $this->contractPartRepository->createFile(base64_decode($content->body));
                $part->setFile($file);
                $this->contractPartRepository->save($part);
            }
        }
    }

    private function updateParties(ContractEntityInterface $contract, $members)
    {
        foreach ($members as $member) {
            /* @var ContractPartyEntityInterface $contract_party */
            $contract_party = ContractParty::whereHas('contract', function ($q) use ($contract) {
                $q->where('id', $contract->getId());
            })->where('yousign_member_id', $member->id)
            ->first(); // todo : replace with repository call

            if ($member->status === 'done') {
                $finished_at = Carbon::createFromFormat('Y-m-d\TH:i:sP', $member->finishedAt);
                if ($member->type === Client::USER_SIGNER
                    && !$contract_party->getIsValidator()
                    && is_null($contract_party->getSignedAt())
                ) {
                    $contract_party->setSignedAt($finished_at);
                    $contract_party->save();
                } elseif ($member->type === Client::USER_VALIDATOR
                    && $contract_party->getIsValidator()
                    && is_null($contract_party->getValidatedAt())
                ) {
                    $contract_party->setValidatedAt($finished_at);
                    $contract_party->save();
                }
            }
        }
    }

    private function check(User $user, ContractEntityInterface $contract)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (is_null($contract)) {
            throw new ContractIsNotFoundException();
        }

        if (! $user->isSupport()) {
            throw new UserIsNotSupportException();
        }

        if (!in_array($contract->getState(), [
            ContractEntityInterface::STATE_DUE,
            ContractEntityInterface::STATE_SIGNED,
            ContractEntityInterface::STATE_TO_SIGN,
            ContractEntityInterface::STATE_TO_VALIDATE,
            ContractEntityInterface::STATE_ACTIVE,
        ])) {
            throw new ContractInvalidStateException();
        }
    }
}
