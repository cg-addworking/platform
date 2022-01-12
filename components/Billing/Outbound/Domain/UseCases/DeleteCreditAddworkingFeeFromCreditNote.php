<?php

namespace Components\Billing\Outbound\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Application\Models\Fee;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\FeeIsNotCreditAddworkingFeeException;
use Components\Billing\Outbound\Domain\Exceptions\FeeNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsAlreadyPaidException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsNotCreditNoteException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\Outbound\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\FeeRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\ModuleRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteCreditAddworkingFeeFromCreditNote implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $enterpriseRepository;
    protected $feeRepository;
    protected $moduleRepository;
    protected $outboundInvoiceRepository;
    protected $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        OutboundInvoiceRepositoryInterface $outboundInvoiceRepository,
        FeeRepositoryInterface $feeRepository,
        ModuleRepositoryInterface $moduleRepository
    ) {
        $this->userRepository            = $userRepository;
        $this->enterpriseRepository      = $enterpriseRepository;
        $this->outboundInvoiceRepository = $outboundInvoiceRepository;
        $this->feeRepository             = $feeRepository;
        $this->moduleRepository          = $moduleRepository;
    }

    public function handle(?User $auth_user, ?Fee $fee, ?OutboundInvoice $outbound_invoice)
    {
        $this->checkUser($auth_user);

        $this->checkOutboundInvoice($outbound_invoice);

        $this->checkFee($fee);

        $customer = $this->enterpriseRepository->find(($outbound_invoice->getEnterprise())->id);

        $this->checkCustomer($customer);

        return $fee->delete();
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
            throw new OutboundInvoiceIsAlreadyPaidException;
        }

        if (! $this->outboundInvoiceRepository->hasParent($outbound_invoice)) {
            throw new OutboundInvoiceIsNotCreditNoteException;
        }
    }

    public function checkFee($fee)
    {
        if (is_null($fee)) {
            throw new FeeNotExistsException;
        }

        if (! $this->feeRepository->hasParent($fee)) {
            throw new FeeIsNotCreditAddworkingFeeException;
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
