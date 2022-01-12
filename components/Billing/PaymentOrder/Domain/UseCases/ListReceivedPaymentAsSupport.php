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

class ListReceivedPaymentAsSupport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $receivedPaymentRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ReceivedPaymentRepositoryInterface $receivedPaymentRepository
    ) {
        $this->userRepository            = $userRepository;
        $this->receivedPaymentRepository = $receivedPaymentRepository;
    }

    public function handle(?User $auth_user)
    {
        $this->checkUser($auth_user);

        return $this->receivedPaymentRepository->listAsSupport();
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
}
