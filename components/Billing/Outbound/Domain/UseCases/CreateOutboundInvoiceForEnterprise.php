<?php

namespace Components\Billing\Outbound\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Exceptions\DeadlineNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseNotExistsException;
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

class CreateOutboundInvoiceForEnterprise implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $enterpriseRepository;
    private $userRepository;
    private $moduleRepository;
    private $outboundInvoiceRepository;
    private $deadlineRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        ModuleRepositoryInterface $moduleRepository,
        OutboundInvoiceRepositoryInterface $outboundInvoiceRepository,
        DeadlineRepositoryInterface $deadlineRepository
    ) {
        $this->userRepository = $userRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->moduleRepository = $moduleRepository;
        $this->outboundInvoiceRepository = $outboundInvoiceRepository;
        $this->deadlineRepository = $deadlineRepository;
    }

    public function handle(?User $auth_user, array $data)
    {
        $this->checkUser($auth_user);

        $customer = $this->enterpriseRepository->find($data['enterprise_id']);

        $this->checkCustomer($customer);

        $deadline = $this->deadlineRepository->findByName($data['deadline']);

        $this->checkDeadline($deadline);

        $invoice = new OutboundInvoice;
        $invoice->setMonth($data['month']);
        $invoice->setInvoicedAt($data['invoiced_at']);
        $invoice->setEnterprise($customer);
        $invoice->setDeadline($deadline);
        $invoice->setStatus(OutboundInvoiceInterface::STATUS_PENDING);
        $invoice->setNumber();

        $dueAt = $this->deadlineRepository->calculDueAt($deadline, $data['invoiced_at'], $data['due_at']);
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

    public function checkDeadline($deadline)
    {
        if (is_null($deadline)) {
            throw new DeadlineNotExistsException;
        }
    }
}
