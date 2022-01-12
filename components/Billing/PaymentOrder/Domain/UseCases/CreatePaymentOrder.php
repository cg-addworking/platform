<?php
namespace Components\Billing\PaymentOrder\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrder;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\PaymentOrder\Domain\Classes\PaymentOrderInterface;
use Components\Billing\PaymentOrder\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\PaymentOrder\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Billing\PaymentOrder\Domain\Exceptions\EnterpriseNotExistsException;
use Components\Billing\PaymentOrder\Domain\Exceptions\IbanNotFoundException;
use Components\Billing\PaymentOrder\Domain\Exceptions\OutboundInvoiceIsNotInGeneratedFileStatusException;
use Components\Billing\PaymentOrder\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\Repositories\DeadlineRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\IbanRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\ModuleRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\OutboundInvoiceRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\PaymentOrderRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreatePaymentOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $enterpriseRepository;
    private $moduleRepository;
    private $deadlineRepository;
    private $ibanRepository;
    private $paymentOrderRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        ModuleRepositoryInterface $moduleRepository,
        DeadlineRepositoryInterface $deadlineRepository,
        IbanRepositoryInterface $ibanRepository,
        PaymentOrderRepositoryInterface $paymentOrderRepository
    ) {
        $this->userRepository            = $userRepository;
        $this->enterpriseRepository      = $enterpriseRepository;
        $this->moduleRepository          = $moduleRepository;
        $this->deadlineRepository        = $deadlineRepository;
        $this->ibanRepository            = $ibanRepository;
        $this->paymentOrderRepository    = $paymentOrderRepository;
    }

    public function handle(
        ?User $authUser,
        ?Enterprise $customer,
        array $data
    ) {
        $this->checkUser($authUser);
        $this->checkCustomer($customer);

        $iban = $this->ibanRepository->find($data['iban_id']);
        $this->checkIban($iban);

        $paymentOrder = new PaymentOrder();
        $paymentOrder->setExecutedAt($data['executed_at']);
        $paymentOrder->setCustomerName($data['customer_name']);
        $paymentOrder->setStatus(PaymentOrderInterface::STATUS_PENDING);
        $paymentOrder->setIban($data['iban_id']);
        $paymentOrder->setEnterprise($customer);
        $paymentOrder->setNumber();
        $paymentOrder->setDebtorName($iban->enterprise->name);
        $paymentOrder->setDebtorIban($iban->iban);
        $paymentOrder->setDebtorBic($iban->bic);
        $paymentOrder->setCreatedBy($authUser->id);

        return $this->paymentOrderRepository->save($paymentOrder);
    }

    private function checkUser($authUser)
    {
        if (is_null($authUser)) {
            throw new UserNotAuthentificatedException();
        }

        if (! $this->userRepository->isSupport($authUser)) {
            throw new UserIsNotSupportException;
        }
    }

    private function checkCustomer($customer)
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

    private function checkIban($iban)
    {
        if (is_null($iban)) {
            throw new IbanNotFoundException();
        }
    }
}
