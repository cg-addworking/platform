<?php
namespace Components\Billing\PaymentOrder\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Billing\PaymentOrder\Application\Notifications\MarkInboundInvoiceAsPaidNotification;
use Components\Billing\PaymentOrder\Domain\Classes\PaymentOrderInterface;
use Components\Billing\PaymentOrder\Domain\Exceptions\PaymentOrderFileNotFoundException;
use Components\Billing\PaymentOrder\Domain\Exceptions\PaymentOrderIsNotInPendingStatusException;
use Components\Billing\PaymentOrder\Domain\Exceptions\PaymentOrderNotFoundException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\PaymentOrder\Domain\Repositories\PaymentOrderItemRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\PaymentOrderRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class MarkPaymentOrderAsPaid implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $paymentOrderRepository;
    private $paymentOrderItemRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PaymentOrderRepositoryInterface $paymentOrderRepository,
        PaymentOrderItemRepositoryInterface $paymentOrderItemRepository
    ) {
        $this->userRepository                = $userRepository;
        $this->paymentOrderRepository        = $paymentOrderRepository;
        $this->paymentOrderItemRepository    = $paymentOrderItemRepository;
    }

    public function handle(
        ?User $auth_user,
        ?PaymentOrderInterface $payment_order
    ) {
        $this->checkUser($auth_user);
        $this->checkPaymentOrder($payment_order);

        foreach ($payment_order->getItems() as $item) {
            $inbound_invoice = $item->getInboundInvoice();
            $this->paymentOrderItemRepository->markInboundInvoiceAsPaid($inbound_invoice);

            $recipients = $inbound_invoice->enterprise->legalRepresentatives;
            Notification::send($recipients, new MarkInboundInvoiceAsPaidNotification($inbound_invoice));
        }

        $payment_order->setStatus(PaymentOrderInterface::STATUS_EXECUTED);
        $saved = $this->paymentOrderRepository->save($payment_order);

        return $saved;
    }

    private function checkUser($auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserNotAuthentificatedException;
        }

        if (!$this->userRepository->isSupport($auth_user)) {
            throw new UserIsNotSupportException;
        }
    }

    private function checkPaymentOrder($payment_order)
    {
        if (is_null($payment_order)) {
            throw new PaymentOrderNotFoundException;
        }

        if ($payment_order->getStatus() != PaymentOrderInterface::STATUS_PENDING) {
            throw new PaymentOrderIsNotInPendingStatusException;
        }

        if (! $this->paymentOrderRepository->hasFile($payment_order)) {
            throw new PaymentOrderFileNotFoundException;
        }
    }
}
