<?php

namespace Components\Contract\Contract\Application\Notifications;

use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestValidationNotification extends Notification
{
    protected $contract;

    public function __construct(
        ContractEntityInterface $contract
    ) {
        $this->contract = $contract;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Vous avez un nouveau contrat prêt pour mise en signature à valider")
            ->markdown('contract::contract.mail.request_validation', [
                'contract_name' => $this->contract->getName(),
                'contract_number' => $this->contract->getNumber(),
                'url' => domain_route(
                    route(
                        'contract.show',
                        $this->contract
                    ),
                    $this->contract->getEnterprise()
                ),
            ]);
    }
}
