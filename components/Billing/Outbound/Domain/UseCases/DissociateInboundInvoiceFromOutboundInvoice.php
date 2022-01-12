<?php
namespace Components\Billing\Outbound\Domain\UseCases;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceItemInterface;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\EnterprisesDoesntHavePartnershipException;
use Components\Billing\Outbound\Domain\Exceptions\InboundInvoiceIsNotAssociatedToThisOutboundInvoiceException;
use Components\Billing\Outbound\Domain\Exceptions\InboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsNotInPendingStatusException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\Outbound\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\InboundInvoiceRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\ModuleRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceItemRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DissociateInboundInvoiceFromOutboundInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $inboundInvoiceRepository;
    private $outboundInvoiceRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $moduleRepository;
    private $outboundInvoiceItemRepository;
    private $outboundInvoiceItem;

    public function __construct(
        OutboundInvoiceRepositoryInterface $outboundInvoiceRepository,
        InboundInvoiceRepositoryInterface $inboundInvoiceRepository,
        UserRepositoryInterface $userRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        ModuleRepositoryInterface $moduleRepository,
        OutboundInvoiceItemRepositoryInterface $outboundInvoiceItemRepository
    ) {
        $this->inboundInvoiceRepository = $inboundInvoiceRepository;
        $this->outboundInvoiceRepository = $outboundInvoiceRepository;
        $this->userRepository = $userRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->moduleRepository = $moduleRepository;
        $this->outboundInvoiceItemRepository = $outboundInvoiceItemRepository;
    }

    public function handle(
        ?User $auth_user,
        ?Enterprise $vendor,
        ?InboundInvoice $inbound_invoice,
        ?Enterprise $customer,
        ?OutboundInvoiceInterface $outbound_invoice
    ) {
        $this->checkUser($auth_user);
        $this->checkCustomer($customer);
        $this->checkVendor($vendor, $customer);
        $this->checkOutboundInvoice($outbound_invoice);
        $this->checkInboundInvoice($inbound_invoice, $outbound_invoice);

        $outboundInvoiceItems = $this->outboundInvoiceRepository
            ->getItemsOfInboundInvoice($outbound_invoice, $inbound_invoice);

        foreach ($outboundInvoiceItems as $item) {
            $this->outboundInvoiceItemRepository->delete($item);
        }

        $outboundInvoiceDissociated = $inbound_invoice->outboundInvoice()->dissociate($outbound_invoice)->save();

        return $this->outboundInvoiceRepository
                ->getItemsOfInboundInvoice($outbound_invoice, $inbound_invoice)
                ->count() == 0;
    }

    public function checkUser($auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserNotAuthentificatedException();
        }

        if (! $this->userRepository->isSupport($auth_user)) {
            throw new UserIsNotSupportException();
        }
    }

    public function checkCustomer($customer)
    {
        if (is_null($customer)) {
            throw new EnterpriseNotExistsException();
        }

        if (! $this->enterpriseRepository->isCustomer($customer)) {
            throw new EnterpriseIsNotCustomerException();
        }

        if (! $this->moduleRepository->hasAccessToBilling($customer)) {
            throw new EnterpriseDoesntHaveAccessToBillingException();
        }
    }

    public function checkVendor($vendor, $customer)
    {
        if (is_null($vendor)) {
            throw new EnterpriseNotExistsException();
        }

        if (! $this->enterpriseRepository->hasPartnershipWith($customer, $vendor)) {
            throw new EnterprisesDoesntHavePartnershipException();
        }
    }

    public function checkOutboundInvoice($outbound_invoice)
    {
        if (is_null($outbound_invoice)) {
            throw new OutboundInvoiceNotExistsException();
        }

        if (! $this->outboundInvoiceRepository->hasStatus(
            $outbound_invoice,
            OutboundInvoiceInterface::STATUS_PENDING
        )) {
            throw new OutboundInvoiceIsNotInPendingStatusException();
        }
    }

    public function checkInboundInvoice($inbound_invoice, $outbound_invoice)
    {
        if (is_null($inbound_invoice)) {
            throw new InboundInvoiceNotExistsException();
        }

        if (! $this->outboundInvoiceRepository->hasInboundInvoice($outbound_invoice, $inbound_invoice)) {
            throw new InboundInvoiceIsNotAssociatedToThisOutboundInvoiceException();
        }
    }
}
