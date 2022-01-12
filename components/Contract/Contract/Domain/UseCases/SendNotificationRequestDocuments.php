<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Domain\Exceptions\ContractDoesHavePartiesException;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\EnterpriseIsNotContractOwnerException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractNotificationEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\CommentRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractNotificationRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\App;

class SendNotificationRequestDocuments
{
    protected $userRepository;
    protected $contractRepository;
    protected $contractNotificationRepository;
    protected $commentRepository;
    protected $contractPartyRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ContractRepositoryInterface $contractRepository,
        ContractNotificationRepositoryInterface $contractNotificationRepository,
        CommentRepositoryInterface $commentRepository,
        ContractPartyRepositoryInterface $contractPartyRepository
    ) {
        $this->userRepository = $userRepository;
        $this->contractRepository = $contractRepository;
        $this->contractNotificationRepository = $contractNotificationRepository;
        $this->commentRepository = $commentRepository;
        $this->contractPartyRepository = $contractPartyRepository;
    }

    public function handle(?User $auth_user, ?Contract $contract)
    {
        $this->checkUser($auth_user);
        $this->checkContract($contract);
        $this->checkOwner($auth_user, $contract);

        $contract_party = $this->contractRepository->getPartiesWithoutOwner($contract)->first();
        if (! $this
                ->contractNotificationRepository
                ->exists(
                    $contract,
                    $contract_party->getSignatory(),
                    ContractNotificationEntityInterface::REQUEST_DOCUMENTS
                )) {
            $this->handleSendNotification($contract, $contract_party);

            $this->createTracking($auth_user, $contract, $contract_party);

            return true;
        }

        return false;
    }

    private function handleSendNotification($contract, $contract_party)
    {
        $this->contractRepository->sendNotificationRequestDocuments(
            $contract,
            $contract_party,
            false
        );

        $this->contractNotificationRepository->createRequestDocumentNotification(
            $contract,
            $contract_party->getSignatory()
        );
    }

    private function createTracking($user, $contract, $contract_party)
    {
        $enterprise_compliance_managers = App::make(UserRepositoryInterface::class)
            ->getVendorComplianceManagerOf($contract_party->getEnterprise(), $contract_party);

        $user_to_notify = [];
        foreach ($enterprise_compliance_managers as $compliance_manager) {
            $user_to_notify[] = $compliance_manager->name;
        }

        $user_to_notify[] = $contract_party->getSignatoryName();

        $notified_users = implode(", ", $user_to_notify);

        ActionTrackingHelper::track(
            $user,
            ActionEntityInterface::CONTRACT_REQUEST_DOCUMENT,
            $contract,
            __(
                'components.contract.contract.application.views.contract.tracking.request_documents',
                [
                    'date' => Carbon::now()->format('d/m/Y'),
                    'pp' => $notified_users,
                    'user' => App::make(UserRepositoryInterface::class)->isSupport($user)
                        ? 'AddWorking'
                        : $user->name,
                ]
            )
        );
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }
    }

    private function checkContract($contract)
    {
        if (is_null($contract)) {
            throw new ContractIsNotFoundException();
        }

        if (! $contract->parties()->count()) {
            throw new ContractDoesHavePartiesException();
        }
    }

    private function checkOwner($auth_user, $contract)
    {
        if ($this->userRepository->isSupport($auth_user)) {
            return true;
        }

        if (! $auth_user->enterprises->contains($contract->getEnterprise())) {
            throw new EnterpriseIsNotContractOwnerException();
        }
    }
}
