<?php

namespace Components\Contract\Contract\Application\Notifications;

use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class RequestContractVariableValueNotification extends Notification
{
    protected $contract;
    protected $url;
    protected $party_1;
    protected $party_2;

    public function __construct(
        ContractEntityInterface $contract,
        string $url,
        ContractPartyEntityInterface $party_1,
        ContractPartyEntityInterface $party_2
    ) {
        $this->contract = $contract;
        $this->url = $url;
        $this->party_1 = $party_1;
        $this->party_2 = $party_2;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->getSubject())
            ->markdown('contract::contract.mail.contract_request_variable_value', [
                'enterprise_name' => $this->contract->getEnterprise()->name,
                'contract_name' => $this->contract->getName(),
                'url' => $this->url,
                'url_contract' => domain_route(
                    route(
                        'contract.show',
                        $this->contract
                    ),
                    $this->contract->getEnterprise()
                ),
                'party_1' => $this->party_1->getEnterprise()->name,
                'party_2' => $this->party_2->getEnterprise()->name,
            ]);
    }

    protected function getSubject(): string
    {
        $subject = __(
            'components.contract.contract.application.views.contract.'
            .'mail.contract_request_variable_value.subject'
        );

        $sogetrel_data = App::make(ContractRepository::class)
            ->getVendorParty($this->contract)
            ->getEnterprise()
            ->sogetrelData;

        $oracle_id = null;

        if ($sogetrel_data) {
            $oracle_id = $sogetrel_data->oracle_id;
        }

        $subject_oracle = __('components.contract.contract.application.views.contract.'
            .'mail.contract_request_variable_value.subject_oracle', ['oracle_id' => $oracle_id]);

        if ($oracle_id) {
            $subject = $subject.$subject_oracle;
        }

        return $subject;
    }
}
