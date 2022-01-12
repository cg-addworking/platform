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

class SendSignContractFollowupNotification extends Command
{
    protected $signature = "contract:send-sign-contract-followup-notification";
    protected $description = 'Sends the sign contract followup notifications';
    protected $contractRepository;
    protected $contractPartyRepository;

    public function __construct(
        ContractRepository $contractRepository,
        ContractPartyRepository $contractPartyRepository
    ) {
        parent::__construct();

        $this->contractRepository = $contractRepository;
        $this->contractPartyRepository = $contractPartyRepository;
    }

    public function handle()
    {
        $this->contractToSignNotification();
    }

    private function getContractsToSign()
    {
        return Contract::whereHas('parties', function ($q) {
            $q->whereNull('signed_at');
        })
        ->where('state', ContractEntityInterface::STATE_TO_SIGN)
        ->whereNotNull('sent_to_signature_at')
        ->whereNotNull('yousign_procedure_id')
        ->with('parties')
        ->get();
    }

    private function contractToSignNotification()
    {
        $contracts_to_sign = $this->getContractsToSign();
        Log::info(count($contracts_to_sign) . " contracts to sign found.");
        $now = Carbon::now();
        $count_notifications_sent = 0;
        foreach ($contracts_to_sign as $contract) {
            $count_notifications_sent = $this->handleContractToSignNotification($contract, $now)
                ? $count_notifications_sent+1
                : $count_notifications_sent;
        }
        Log::info(
            $count_notifications_sent .
            " sign contract notifications were sent."
        );
    }

    private function handleContractToSignNotification(ContractEntityInterface $contract, $now)
    {
        $notification_date = $contract->getSentToSignatureAt();
        foreach ($this->contractRepository->getSignatoryParties($contract) as $party) {
            if (!is_null($party->getSignedAt()) && $party->getSignedAt() > $notification_date) {
                $notification_date = $party->getSignedAt();
            }
        }

        $days_since_last_sign_action = $notification_date->diffInDays($now);
        $party_to_notify = $this->contractPartyRepository->getNextPartyThatShouldSign($contract);
        if (!is_null($party_to_notify)
            && $days_since_last_sign_action % 2 == 0 // every two days
            && $days_since_last_sign_action < 31 // for 30 days
            && $days_since_last_sign_action > 0
        ) {
            $this->contractRepository->sendNotificationToSignContract($contract, $party_to_notify);
            return true;
        }
        return false;
    }
}
