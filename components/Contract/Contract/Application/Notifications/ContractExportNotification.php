<?php

namespace Components\Contract\Contract\Application\Notifications;

use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContractExportNotification extends Notification
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var Enterprise
     */
    protected $enterprise;

    public function __construct(
        Enterprise $enterprise,
        string $url
    ) {
        $this->enterprise = $enterprise;
        $this->url        = $url;
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
                    'components.contract.contract.application.views.contract.mail.export.subject',
                    ['enterprise_name' => $this->enterprise->name]
                )
            )
            ->markdown('contract::contract.mail.contract_export', [
                'url' => domain_route(
                    $this->url,
                    $this->enterprise
                ),
            ]);
    }
}
