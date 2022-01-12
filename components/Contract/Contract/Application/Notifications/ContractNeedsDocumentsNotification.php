<?php

namespace Components\Contract\Contract\Application\Notifications;

use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContractNeedsDocumentsNotification extends Notification
{
    protected $contract;
    protected $contract_party;
    protected $is_followup;

    public function __construct(
        ContractEntityInterface $contract,
        ContractPartyEntityInterface $contract_party,
        $is_followup = true
    ) {
        $this->contract = $contract;
        $this->contract_party = $contract_party;
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
                ? __('components.contract.contract.application.views.contract.mail.contract_needs_documents.followup')
                : '')
                . __(
                    'components.contract.contract.application.views.contract.mail.contract_needs_documents.subject',
                    [ 'enterprise_name' => $this->contract->getEnterprise()->name ]
                )
            )
            ->markdown('contract::contract.mail.contract_needs_documents', [
                'enterprise_name' => $this->contract->getEnterprise()->name,
                'contract_name' => $this->contract->getName(),
                'url_doc' => domain_route(
                    route(
                        'contract.party.document.index',
                        [$this->contract, $this->contract_party]
                    ),
                    $this->contract->getEnterprise()
                ),
                'url_contract' => domain_route(
                    route(
                        'contract.show',
                        $this->contract
                    ),
                    $this->contract->getEnterprise()
                ),
            ]);
    }
}
