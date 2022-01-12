<?php

namespace Components\Billing\PaymentOrder\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\PaymentOrder\Domain\Repositories\ReceivedPaymentRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\UserRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\PaymentOrder\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Billing\PaymentOrder\Domain\Exceptions\EnterpriseNotExistsException;
use Components\Billing\PaymentOrder\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\ModuleRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ListReceivedPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $receivedPaymentRepository;
    private $enterpriseRepository;
    private $moduleRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ReceivedPaymentRepositoryInterface $receivedPaymentRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        ModuleRepositoryInterface $moduleRepository
    ) {
        $this->userRepository            = $userRepository;
        $this->receivedPaymentRepository = $receivedPaymentRepository;
        $this->enterpriseRepository      = $enterpriseRepository;
        $this->moduleRepository          = $moduleRepository;
    }

    public function handle(?User $auth_user, ?Enterprise $enterprise)
    {
        $this->checkUser($auth_user);

        $this->checkEnterprise($enterprise);

        return $this->receivedPaymentRepository->list($enterprise);
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

    private function checkEnterprise($customer)
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
}
