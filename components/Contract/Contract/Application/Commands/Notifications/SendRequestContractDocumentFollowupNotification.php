<?php

namespace Components\Contract\Contract\Application\Commands\Notifications;

use Carbon\Carbon;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Repositories\ContractNotificationRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractNotificationEntityInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendRequestContractDocumentFollowupNotification extends Command
{
    protected $signature = "contract:send-request-contract-document-followup-notification";
    protected $description = 'Sends the request contract document followup notifications';
    protected $contractRepository;
    protected $contractNotificationRepository;
    protected $contractPartyRepository;

    public function __construct(
        ContractRepository $contractRepository,
        ContractNotificationRepository $contractNotificationRepository,
        ContractPartyRepository $contractPartyRepository
    ) {
        parent::__construct();

        $this->contractRepository = $contractRepository;
        $this->contractNotificationRepository = $contractNotificationRepository;
        $this->contractPartyRepository = $contractPartyRepository;
    }

    public function handle()
    {
        $this->requestDocumentNotification();
    }

    private function getContractsWithMissingDocuments()
    {
        return Contract::whereHas('parties', function ($q) {
            $q->whereNull('signed_at');
        })
        ->whereHas('contractNotification', function ($q) {
            $q->where('notification_name', ContractNotificationEntityInterface::REQUEST_DOCUMENTS);
        })
        ->where('state', ContractEntityInterface::STATE_MISSING_DOCUMENTS)
        ->whereNull('sent_to_signature_at')
        ->whereNull('yousign_procedure_id')
        ->with(['parties', 'contractNotification',])
        ->get();
    }

    private function requestDocumentNotification()
    {
        $contracts_to_complete = $this->getContractsWithMissingDocuments();

        Log::info(count($contracts_to_complete) . " contracts to complete found.");
        $now = Carbon::now();
        $count_notifications_sent = 0;
        foreach ($contracts_to_complete as $contract) {
            $count_notifications_sent = $this->handleRequestDocumentNotification($contract, $now)
                ? $count_notifications_sent+1
                : $count_notifications_sent;
        }
        Log::info(
            $count_notifications_sent .
            " request document notifications were sent."
        );
    }

    private function handleRequestDocumentNotification(ContractEntityInterface $contract, $now)
    {
        $contract_party = $this->contractRepository->getPartiesWithoutOwner($contract)->first();

        if ($this->contractRepository->checkIfSendNotificationDocumentsToParty(
            $contract,
            $contract_party
        )) {
            $contract_notification = $this->contractNotificationRepository->findNotification(
                $contract,
                $contract_party->getSignatory(),
                ContractNotificationEntityInterface::REQUEST_DOCUMENTS
            );

            if (isset($contract_notification)) {
                $notification_date = $contract_notification->getSentDate();
                $days_since_first_notification = $notification_date->diffInDays($now);
                if (!is_null($contract_party)
                    && $days_since_first_notification % 3 == 0 // every three days
                    && $days_since_first_notification < 45 // for 45 days
                    && $days_since_first_notification > 0
                ) {
                    $this->contractRepository->sendNotificationRequestDocuments($contract, $contract_party);
                    return true;
                }
            }
        }
        return false;
    }
}
