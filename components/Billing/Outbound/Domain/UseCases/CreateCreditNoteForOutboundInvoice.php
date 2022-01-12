<?php

namespace Components\Billing\Outbound\Domain\UseCases;

use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\Outbound\Domain\Repositories\DeadlineRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\ModuleRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateCreditNoteForOutboundInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $outboundInvoiceRepository;
    private $enterpriseRepository;
    private $moduleRepository;
    private $deadlineRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        OutboundInvoiceRepositoryInterface $outboundInvoiceRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        ModuleRepositoryInterface $moduleRepository,
        DeadlineRepositoryInterface $deadlineRepository
    ) {
        $this->userRepository            = $userRepository;
        $this->outboundInvoiceRepository = $outboundInvoiceRepository;
        $this->enterpriseRepository      = $enterpriseRepository;
        $this->moduleRepository          = $moduleRepository;
        $this->deadlineRepository        = $deadlineRepository;
    }

    public function handle(?User $auth_user, ?OutboundInvoiceInterface $outbound_invoice)
    {
        $this->checkUser($auth_user);
        $this->checkOutboundInvoice($outbound_invoice);

        $customer = $this->enterpriseRepository->find(($outbound_invoice->getEnterprise())->id);

        $this->checkCustomer($customer);

        $invoice = new OutboundInvoice;
        $invoice->setMonth($outbound_invoice->getMonth());
        $invoice->setInvoicedAt($invoicedAt = Carbon::now()->format('Y-m-d'));
        $invoice->setEnterprise($customer);
        $invoice->setDeadline($outbound_invoice->getDeadline());
        $invoice->setStatus(OutboundInvoiceInterface::STATUS_PENDING);
        $invoice->setNumber();
        $invoice->setParent($outbound_invoice->getId());

        $dueAt = $this->deadlineRepository->calculDueAt($outbound_invoice->getDeadline(), $invoicedAt);
        $invoice->setDueAt($dueAt);

        return $this->outboundInvoiceRepository->save($invoice);
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
