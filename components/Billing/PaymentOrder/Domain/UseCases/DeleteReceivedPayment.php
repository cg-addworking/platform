<?php

namespace Components\Billing\PaymentOrder\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Billing\PaymentOrder\Domain\Classes\ReceivedPaymentInterface;
use Components\Billing\PaymentOrder\Domain\Exceptions\ReceivedPaymentNotExistsException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\PaymentOrder\Domain\Repositories\ReceivedPaymentRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\UserRepositoryInterface;

class DeleteReceivedPayment
{
    private $userRepository;
    private $receivedPaymentRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ReceivedPaymentRepositoryInterface $receivedPaymentRepository
    ) {
        $this->userRepository = $userRepository;
        $this->receivedPaymentRepository = $receivedPaymentRepository;
    }

    public function handle(?User $auth_user, ?ReceivedPaymentInterface $received_payment)
    {
        $this->checkUser($auth_user);
        $this->checkReceivedPayment($received_payment);

        return $this->receivedPaymentRepository->delete($received_payment);
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

    public function checkReceivedPayment($received_payment)
    {
        if (is_null($received_payment)) {
            throw new ReceivedPaymentNotExistsException;
        }
    }
}
