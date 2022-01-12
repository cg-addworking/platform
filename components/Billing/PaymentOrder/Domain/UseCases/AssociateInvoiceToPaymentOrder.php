<?php
namespace Components\Billing\PaymentOrder\Domain\UseCases;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\User\User;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrderItem;
use Components\Billing\PaymentOrder\Application\Repositories\OutboundInvoiceItemRepository;
use Components\Billing\PaymentOrder\Application\Repositories\PaymentOrderItemRepository;
use Components\Billing\PaymentOrder\Domain\Classes\PaymentOrderInterface;
use Components\Billing\PaymentOrder\Domain\Exceptions\IbanNotFoundException;
use Components\Billing\PaymentOrder\Domain\Exceptions\InboundInvoiceIsAlreadyPaidException;
use Components\Billing\PaymentOrder\Domain\Exceptions\InboundInvoiceNotExistsException;
use Components\Billing\PaymentOrder\Domain\Exceptions\PaymentOrderIsNotInPendingStatusException;
use Components\Billing\PaymentOrder\Domain\Exceptions\PaymentOrderNotFoundException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\PaymentOrder\Domain\Repositories\IbanRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\InboundInvoiceRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\PaymentOrderRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AssociateInvoiceToPaymentOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $ibanRepository;
    private $paymentOrderRepository;
    private $inboundInvoiceRepository;
    private $paymentOrderItemRepository;
    private $outboundInvoiceItemRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        IbanRepositoryInterface $ibanRepository,
        PaymentOrderRepositoryInterface $paymentOrderRepository,
        InboundInvoiceRepositoryInterface $inboundInvoiceRepository,
        PaymentOrderItemRepository $paymentOrderItemRepository,
        OutboundInvoiceItemRepository $outboundInvoiceItemRepository
    ) {
        $this->userRepository             = $userRepository;
        $this->ibanRepository             = $ibanRepository;
        $this->paymentOrderRepository     = $paymentOrderRepository;
        $this->inboundInvoiceRepository   = $inboundInvoiceRepository;
        $this->paymentOrderItemRepository = $paymentOrderItemRepository;
        $this->outboundInvoiceItemRepository = $outboundInvoiceItemRepository;
    }

    public function handle(
        ?User $auth_user,
        ?InboundInvoice $inbound_invoice,
        ?PaymentOrderInterface $payment_order
    ) {
        $this->checkUser($auth_user);
        $this->checkPaymentOrder($payment_order);
        $this->checkInboundInvoice($inbound_invoice);

        $iban = $this->ibanRepository->findByEnterprise($inbound_invoice->enterprise);
        
        $this->checkIban($iban);

        $item = new PaymentOrderItem;
        $item->setPaymentOrder($payment_order);
        $item->setInboundInvoice($inbound_invoice);
        $item->setOutboundInvoice($inbound_invoice->outboundInvoice);
        $item->setIban($iban);
        $item->setNumber();
        $item->setEnterpriseName($iban->enterprise->name);
        $item->setEnterpriseIban($iban->iban);
        $item->setEnterpriseBic($iban->bic);

        $amount = $this->outboundInvoiceItemRepository->getAmountIncludingAllTaxesOfInboundInvoice(
            $inbound_invoice,
            $inbound_invoice->outboundInvoice
        );

        $item->setAmount($amount);

        return $this->paymentOrderItemRepository->save($item);
    }

    private function checkUser($auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserNotAuthentificatedException;
        }

        if (! $this->userRepository->isSupport($auth_user)) {
            throw new UserIsNotSupportException;
        }
    }

    private function checkInboundInvoice($inbound_invoice)
    {
        if (is_null($inbound_invoice)) {
            throw new InboundInvoiceNotExistsException;
        }

        if ($this->inboundInvoiceRepository->hasStatus($inbound_invoice, InboundInvoice::STATUS_PAID)) {
            throw new InboundInvoiceIsAlreadyPaidException;
        }

        if ($this->inboundInvoiceRepository->hasPaymentOrder($inbound_invoice)) {
            throw new InboundInvoiceIsAlreadyPaidException;
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
    }

    private function checkIban($iban)
    {
        if (is_null($iban)) {
            throw new IbanNotFoundException;
        }
    }
}
