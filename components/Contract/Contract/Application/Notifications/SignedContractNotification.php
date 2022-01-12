<?php

namespace Components\Contract\Contract\Application\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\Addworking\User\User;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;

class SignedContractNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $contract;
    protected $owner;

    public function __construct(
        ContractEntityInterface $contract,
        User $owner
    ) {
        $this->contract = $contract;
        $this->owner = $owner;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(
                __(
                    'components.contract.contract.application.views.contract.mail.signed_contract.subject',
                    ['name' => $this->contract->getName()]
                )
            )
            ->markdown('contract::contract.mail.signed_contract', [
                'contract_name' => $this->contract->getName(),
                'name' => $this->owner->name,
                'url' => domain_route(
                    route(
                        'contract.show',
                        $this->contract
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
