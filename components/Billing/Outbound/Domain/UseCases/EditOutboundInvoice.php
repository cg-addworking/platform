<?php
namespace Components\Billing\Outbound\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Exceptions\DeadlineNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsAlreadyValidatedException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotMemberOfThisEnterpriseException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\Repositories\DeadlineRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\MemberRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\ModuleRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EditOutboundInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $outboundInvoiceRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $moduleRepository;
    private $memberRepository;
    private $deadlineRepository;

    public function __construct(
        OutboundInvoiceRepositoryInterface $outboundInvoiceRepository,
        UserRepositoryInterface $userRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        ModuleRepositoryInterface $moduleRepository,
        MemberRepositoryInterface $memberRepository,
        DeadlineRepositoryInterface $deadlineRepository
    ) {
        $this->outboundInvoiceRepository = $outboundInvoiceRepository;
        $this->userRepository = $userRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->moduleRepository = $moduleRepository;
        $this->memberRepository = $memberRepository;
        $this->deadlineRepository = $deadlineRepository;
    }

    public function handle(
        ?User $authUser,
        ?Enterprise $customer,
        ?OutboundInvoiceInterface $outboundInvoice,
        array $data
    ) {
        $this->checkUser($authUser);
        $this->checkCustomer($customer);
        $this->checkOutboundInvoice($outboundInvoice);

        $deadline = $this->deadlineRepository->findByName($data['deadline']);
        $this->checkDeadline($deadline);

        $invoice = $outboundInvoice;
        $invoice->setMonth($data['month']);
        $invoice->setInvoicedAt($data['invoiced_at']);
        $invoice->setDeadline($deadline);
        $invoice->setStatus($data['status']);
        $invoice->updatedBy()->associate($authUser);

        $dueAt = $this->deadlineRepository->calculDueAt($deadline, $data['invoiced_at'], $data['due_at']);
        $invoice->setDueAt($dueAt);

        return $this->outboundInvoiceRepository->save($invoice);
    }

    public function checkUser($authUser)
    {
        if (is_null($authUser)) {
            throw new UserNotAuthentificatedException();
        }

        if (! $this->userRepository->isSupport($authUser)) {
            throw new UserIsNotSupportException;
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

    public function checkOutboundInvoice($outboundInvoice)
    {
        if (is_null($outboundInvoice)) {
            throw new OutboundInvoiceNotExistsException();
        }

        if ($this->outboundInvoiceRepository->isValidated($outboundInvoice)) {
            throw new OutboundInvoiceIsAlreadyValidatedException();
        }
    }

    public function checkDeadline($deadline)
    {
        if (is_null($deadline)) {
            throw new DeadlineNotExistsException();
        }
    }
}
