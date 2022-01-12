<?php

namespace Components\Contract\Contract\Application\Notifications;

use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContractToSignNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $contract;
    protected $party_to_notify;
    protected $is_followup;

    public function __construct(
        ContractEntityInterface $contract,
        ContractPartyEntityInterface $party_to_notify,
        $is_followup = true
    ) {
        $this->contract = $contract;
        $this->party_to_notify = $party_to_notify;
        $this->is_followup = $is_followup;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(
                ($this->is_followup
                ? __('components.contract.contract.application.views.contract.mail.contract_to_sign.followup')
                : '')
                . __('components.contract.contract.application.views.contract.mail.contract_to_sign.subject')
            )
            ->markdown('contract::contract.mail.new_contract_to_sign', [
                'contract_name' => $this->contract->getName(),
                'owner' => $this->contract->getEnterprise()->name,
                'url' => domain_route(
                    route(
                        'contract.sign',
                        [
                            $this->contract,
                            $this->party_to_notify
                        ]
                    ),
                    $this->contract->getEnterprise()
                ),
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
