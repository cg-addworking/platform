<?php
namespace Components\Billing\Outbound\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceItemInterface;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseNotExistsException;
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

class CreateCreditLineForOutboundInvoiceItem implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $outboundInvoiceItemRepository;
    private $outboundInvoiceRepository;
    private $enterpriseRepository;
    private $moduleRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        OutboundInvoiceItemRepositoryInterface $outboundInvoiceItemRepository,
        OutboundInvoiceRepositoryInterface $outboundInvoiceRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        ModuleRepositoryInterface $moduleRepository
    ) {
        $this->userRepository                = $userRepository;
        $this->outboundInvoiceItemRepository = $outboundInvoiceItemRepository;
        $this->outboundInvoiceRepository     = $outboundInvoiceRepository;
        $this->enterpriseRepository          = $enterpriseRepository;
        $this->moduleRepository              = $moduleRepository;
    }

    public function handle(
        ?User $auth_user,
        ?OutboundInvoiceInterface $outbound_invoice,
        ?OutboundInvoiceItemInterface $old_outbound_item
    ) {
        $this->checkUser($auth_user);
        $this->checkOutboundInvoiceItem($old_outbound_item);
        $this->checkOutboundInvoice($outbound_invoice);

        $customer = $this->enterpriseRepository->find(($old_outbound_item->getOutboundInvoice()->getEnterprise())->id);

        $this->checkCustomer($customer);

        $invoiceItem = new OutboundInvoiceItem;
        $invoiceItem->setInvoice($outbound_invoice);
        $invoiceItem->setVatRate($old_outbound_item->getVatRate()->id);
        $invoiceItem->setLabel($old_outbound_item->getLabel());
        $invoiceItem->setQuantity($old_outbound_item->getQuantity());
        $invoiceItem->setUnitPrice(
            $this->outboundInvoiceItemRepository->setNegativeUnitPrice($old_outbound_item->getUnitPrice())
        );
        $invoiceItem->setNumber();
        $invoiceItem->setParent($old_outbound_item->getId());

        if (($old_outbound_item->getInboundInvoiceItem())->exists) {
            $invoiceItem->setInboundInvoiceItem($old_outbound_item->getInboundInvoiceItem()->id);
        }

        if (! is_null($old_outbound_item->getVendor())) {
            $invoiceItem->setVendor($old_outbound_item->getVendor()->id);
        }
        
        $old_outbound_item->setIsCanceled(true);
        $this->outboundInvoiceItemRepository->save($old_outbound_item);

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

    public function checkOutboundInvoiceItem($old_outbound_item)
    {
        if (is_null($old_outbound_item)) {
            throw new OutboundInvoiceItemNotExistsException;
        }
    }

    public function checkOutboundInvoice($outbound_invoice)
    {
        if (is_null($outbound_invoice)) {
            throw new OutboundInvoiceNotExistsException;
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
