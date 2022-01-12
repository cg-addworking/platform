<?php

namespace Components\Contract\Contract\Application\Notifications;

use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContractExpiringCustomerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $enterprise;
    private $day;

    public function __construct(Enterprise $enterprise, $day)
    {
        $this->enterprise = $enterprise;
        $this->day = $day;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $translation_base = "components.contract.contract.application.views.contract.mail.expiring_contract_customer";

        return (new MailMessage)
            ->subject(
                $this->day === "30" ?
                    __("{$translation_base}.subject_one") :
                    __("{$translation_base}.subject_two")
            )->markdown('contract::contract.mail.expiring_contract_customer_message', [
                'url'    => domain_route(
                    route(
                        'contract.index',
                        [
                            'filter' => [
                                'enterprises' => [
                                    $this->enterprise->id
                                ],
                                'expiring_contracts' => $this->day,
                                'states' => ['active']
                            ]
                        ]
                    ),
                    $this->enterprise
                ),
                'day' => $this->day,
                'enterprise' => $this->enterprise,
            ]);
    }
}
