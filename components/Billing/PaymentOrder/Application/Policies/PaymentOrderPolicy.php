<?php
namespace Components\Billing\PaymentOrder\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrder;
use Components\Billing\PaymentOrder\Application\Repositories\PaymentOrderRepository;
use Components\Billing\PaymentOrder\Application\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PaymentOrderPolicy
{
    use HandlesAuthorization;

    protected $userRepository;
    protected $paymentOrderRepository;

    public function __construct(
        UserRepository $userRepository,
        PaymentOrderRepository $paymentOrderRepository
    ) {
        $this->userRepository = $userRepository;
        $this->paymentOrderRepository = $paymentOrderRepository;
    }

    public function create(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function edit(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function index(User $user)
    {
        return $this->create($user);
    }

    public function show(User $user)
    {
        return $this->create($user);
    }

    public function associate(User $user, PaymentOrder $payment_order)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if ($payment_order->getStatus() == PaymentOrder::STATUS_EXECUTED) {
            return Response::deny("Payment order already executed");
        }

        return Response::allow();
    }

    public function generate(User $user, PaymentOrder $payment_order)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if (! count($payment_order->getItems())) {
            return Response::deny("Payment order is empty");
        }

        if ($payment_order->getStatus() == PaymentOrder::STATUS_EXECUTED) {
            return Response::deny("Payment order already executed");
        }

        return Response::allow();
    }

    public function execute(User $user, PaymentOrder $payment_order)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if (! $this->paymentOrderRepository->hasFile($payment_order)) {
            return Response::deny("Payment order file not found");
        }

        if ($payment_order->getStatus() == PaymentOrder::STATUS_EXECUTED) {
            return Response::deny("Payment order already executed");
        }

        return Response::allow();
    }

    public function dissociate(User $user)
    {
        return $this->create($user);
    }

    public function delete(User $user)
    {
        return $this->create($user);
    }

    public function storeDissociate(User $user, PaymentOrder $payment_order)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if ($payment_order->getStatus() == PaymentOrder::STATUS_EXECUTED) {
            return Response::deny("Payment order already executed");
        }

        return Response::allow();
    }
}
