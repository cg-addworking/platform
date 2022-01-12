<?php

namespace Components\Billing\Outbound\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Outbound\Application\Repositories\ModuleRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceItemRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsNotInPendingStatusException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\Exceptions\UserNotAuthentificatedException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddAdHocLineToOutboundInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $enterpriseRepository;
    private $moduleRepository;
    private $outboundInvoiceRepository;
    private $outboundInvoiceItemRepository;

    public function __construct(
        UserRepository $userRepository,
        EnterpriseRepository $enterpriseRepository,
        ModuleRepository $moduleRepository,
        OutboundInvoiceRepository $outboundInvoiceRepository,
        OutboundInvoiceItemRepository $outboundInvoiceItemRepository
    ) {
        $this->userRepository                = $userRepository;
        $this->enterpriseRepository          = $enterpriseRepository;
        $this->moduleRepository              = $moduleRepository;
        $this->outboundInvoiceRepository     = $outboundInvoiceRepository;
        $this->outboundInvoiceItemRepository = $outboundInvoiceItemRepository;
    }

    public function handle(
        ?User $auth_user,
        ?Enterprise $customer,
        ?OutboundInvoiceInterface $outbound_invoice,
        array $data
    ) {
        $this->checkUser($auth_user);

        $this->checkOutboundInvoice($outbound_invoice);

        $this->checkCustomer($customer);

        $invoiceItem = new OutboundInvoiceItem;
        $invoiceItem->setInvoice($outbound_invoice);
        $invoiceItem->setVatRate($data['vat_rate_id']);
        $invoiceItem->setLabel($data['label']);
        $invoiceItem->setQuantity($data['quantity']);
        $invoiceItem->setUnitPrice($data['unit_price']);
        $invoiceItem->setNumber();

        return $this->outboundInvoiceItemRepository->save($invoiceItem);
    }

    public function checkUser($auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserNotAuthentificatedException;
        }

        if (! $this->userRepository->isSupport($auth_user)) {
            throw new UserIsNotSupportException;
        }
    }

    public function checkOutboundInvoice($outbound_invoice)
    {
        if (is_null($outbound_invoice)) {
            throw new OutboundInvoiceNotExistsException;
        }

        if (! $this->outboundInvoiceRepository->hasStatus(
            $outbound_invoice,
            OutboundInvoiceInterface::STATUS_PENDING
        )) {
            throw new OutboundInvoiceIsNotInPendingStatusException;
        }
    }

    public function checkCustomer($customer)
    {
        if (is_null($customer)) {
            throw new EnterpriseNotExistsException;
        }

        if (! $this->enterpriseRepository->isCustomer($customer)) {
            throw new EnterpriseIsNotCustomerException;
        }

        if (! $this->moduleRepository->hasAccessToBilling($customer)) {
            throw new EnterpriseDoesntHaveAccessToBillingException;
        }
    }
}
