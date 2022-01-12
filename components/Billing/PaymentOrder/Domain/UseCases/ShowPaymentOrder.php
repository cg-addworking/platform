<?php

namespace Components\Billing\PaymentOrder\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Billing\PaymentOrder\Application\Repositories\PaymentOrderRepository;
use Components\Billing\PaymentOrder\Application\Repositories\UserRepository;
use Components\Billing\PaymentOrder\Domain\Classes\PaymentOrderInterface;
use Components\Billing\PaymentOrder\Domain\Exceptions\PaymentOrderDoesNotExistsException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserNotAuthentificatedException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ShowPaymentOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $paymentOrderRepository;

    public function __construct(
        UserRepository $userRepository,
        PaymentOrderRepository $paymentOrderRepository
    ) {
        $this->userRepository         = $userRepository;
        $this->paymentOrderRepository = $paymentOrderRepository;
    }

    public function handle(?User $auth_user, ?PaymentOrderInterface $payment_order)
    {
        $this->checkUser($auth_user);
        $this->checkPaymentOrder($payment_order);

        return $payment_order;
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

    public function checkPaymentOrder($payment_order)
    {
        if (is_null($payment_order)) {
            throw new PaymentOrderDoesNotExistsException;
        }
    }
}
