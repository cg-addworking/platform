<?php

namespace Components\Contract\Contract\Application\Notifications;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Models\Contract;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class ContractExpiringVendorNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $contract;
    private $day;

    public function __construct(Contract $contract, $day)
    {
        $this->contract = $contract;
        $this->day = $day;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $translation_base = "components.contract.contract.application.views.contract.mail.expiring_contract_vendor";

        return (new MailMessage)
            ->subject(__("{$translation_base}.subject_one"))
            ->markdown('contract::contract.mail.expiring_contract_vendor_message', [
                'contract' => $this->contract,
                'day' => $this->day,
                'url' => domain_route(
                    route('contract.show', $this->contract),
                    $this->contract->getEnterprise()
                ),
            ]);
    }
}
