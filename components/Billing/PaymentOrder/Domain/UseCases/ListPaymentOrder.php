<?php

namespace Components\Billing\PaymentOrder\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Billing\PaymentOrder\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\PaymentOrder\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\PaymentOrder\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Billing\PaymentOrder\Domain\Exceptions\EnterpriseNotExistsException;
use Components\Billing\PaymentOrder\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\PaymentOrder\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\PaymentOrderRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ListPaymentOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $paymentOrderRepository;
    private $enterpriseRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        PaymentOrderRepositoryInterface $paymentOrderRepository
    ) {
        $this->userRepository         = $userRepository;
        $this->paymentOrderRepository = $paymentOrderRepository;
        $this->enterpriseRepository   = $enterpriseRepository;
    }

    public function handle(?User $auth_user, ?Enterprise $enterprise)
    {
        $this->checkUser($auth_user);
        $this->checkEnterprise($enterprise);

        return $this->paymentOrderRepository->list($enterprise);
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

    public function checkEnterprise($enterprise)
    {
        if (is_null($enterprise)) {
            throw new EnterpriseNotExistsException();
        }

        if (! $this->enterpriseRepository->isCustomer($enterprise)) {
            throw new EnterpriseIsNotCustomerException();
        }
    }
}
