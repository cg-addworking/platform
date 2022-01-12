<?php

namespace Components\Contract\Contract\Application\Notifications;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewContractToSendToSignatureNotification extends Notification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contract;
    protected $user;

    public function __construct(
        ContractEntityInterface $contract,
        User $user
    ) {
        //$this->onConnection('sqs_for_contracts');

        $this->contract = $contract;
        $this->user = $user;
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
                    'components.contract.contract.application.views.contract.'.
                    'mail.contract_to_send_to_signature.subject',
                    ['contract_name' => $this->contract->getName()]
                )
            )
            ->markdown('contract::contract.mail.new_contract_to_send_to_signature', [
                'contract_name' => $this->contract->getName(),
                'owner' => $this->contract->getEnterprise()->name,
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
