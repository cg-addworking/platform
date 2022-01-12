<?php
namespace Components\Billing\Outbound\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceItemInterface;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsAlreadyPaidException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceItemNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\Outbound\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\ModuleRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceItemRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteAdHocLineFromOutboundInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $outboundInvoiceRepository;
    private $outboundInvoiceItemRepository;
    private $enterpriseRepository;
    private $moduleRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        OutboundInvoiceRepositoryInterface $outboundInvoiceRepository,
        OutboundInvoiceItemRepositoryInterface $outboundInvoiceItemRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        ModuleRepositoryInterface $moduleRepository
    ) {
        $this->userRepository                = $userRepository;
        $this->outboundInvoiceRepository     = $outboundInvoiceRepository;
        $this->outboundInvoiceItemRepository = $outboundInvoiceItemRepository;
        $this->enterpriseRepository          = $enterpriseRepository;
        $this->moduleRepository              = $moduleRepository;
    }

    public function handle(
        ?User $auth_user,
        ?OutboundInvoiceInterface $outbound_invoice,
        ?OutboundInvoiceItemInterface $outbound_invoice_item
    ) {
        $this->checkUser($auth_user);
        $this->checkOutboundInvoice($outbound_invoice);
        $this->checkOutboundInvoiceItem($outbound_invoice_item);

        $customer = $this->enterpriseRepository->find(($outbound_invoice->getEnterprise())->id);

        $this->checkCustomer($customer);

        $deleted = $outbound_invoice_item->delete();

        return $deleted;
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

        if ($this->outboundInvoiceRepository->hasStatus($outbound_invoice, 'paid')) {
            throw new OutboundInvoiceIsAlreadyPaidException();
        }
    }

    public function checkOutboundInvoiceItem($outbound_invoice_item)
    {
        if (is_null($outbound_invoice_item)) {
            throw new OutboundInvoiceItemNotExistsException;
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
