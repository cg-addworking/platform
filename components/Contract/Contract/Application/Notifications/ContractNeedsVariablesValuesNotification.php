<?php

namespace Components\Contract\Contract\Application\Notifications;

use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContractNeedsVariablesValuesNotification extends Notification
{
    protected $contract;
    protected $first_contract_party;

    public function __construct(ContractEntityInterface $contract, ContractPartyEntityInterface $first_contract_party)
    {
        $this->contract = $contract;
        $this->first_contract_party = $first_contract_party;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $contractualization_language = $this->first_contract_party
                ->getEnterprise()->getContractualizationLanguage() ?? 'fr';

        return (new MailMessage)
            ->subject(
                __('components.contract.contract.application.views.contract.'
                    .'mail.contract_needs_variables_values.subject', [], $contractualization_language)
            )
            ->markdown('contract::contract.mail.contract_needs_variables_values', [
                'enterprise_name' => $this->contract->getEnterprise()->name,
                'contract_name' => $this->contract->getName(),
                'contractualization_language' => $contractualization_language,
                'url' => domain_route(
                    route(
                        'contract.show',
                        $this->contract
                    ),
                    $this->contract->getEnterprise()
                )
                ]);
    }
}
