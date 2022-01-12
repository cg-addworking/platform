<?php

namespace Components\Billing\PaymentOrder\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Billing\PaymentOrder\Application\Models\ReceivedPayment;
use Components\Billing\PaymentOrder\Domain\Exceptions\IbanNotFoundException;
use Components\Billing\PaymentOrder\Domain\Exceptions\ReceivedPaymentNotExistsException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\PaymentOrder\Domain\Repositories\IbanRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\ReceivedPaymentRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\UserRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\OutboundInvoiceRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\ReceivedPaymentOutboundInvoiceRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EditReceivedPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $ibanRepository;
    private $receivedPaymentRepository;
    private $outboundInvoiceRepository;
    private $receivedPaymentOutboundInvoiceRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        IbanRepositoryInterface $ibanRepository,
        ReceivedPaymentRepositoryInterface $receivedPaymentRepository,
        OutboundInvoiceRepositoryInterface $outboundInvoiceRepository,
        ReceivedPaymentOutboundInvoiceRepositoryInterface $receivedPaymentOutboundInvoiceRepository
    ) {
        $this->userRepository            = $userRepository;
        $this->ibanRepository            = $ibanRepository;
        $this->receivedPaymentRepository = $receivedPaymentRepository;
        $this->outboundInvoiceRepository = $outboundInvoiceRepository;
        $this->receivedPaymentOutboundInvoiceRepository = $receivedPaymentOutboundInvoiceRepository;
    }

    public function handle(?User $auth_user, ?ReceivedPayment $received_payment, $data)
    {
        $this->checkUser($auth_user);
        $this->checkReceivedPayment($received_payment);

        $iban = $this->ibanRepository->find($data['iban']);

        $this->checkIban($iban);

        $payment = $received_payment;
        $payment->setIban($iban);
        $payment->setCreatedBy($auth_user);
        $payment->setBankReferencePayment($data['bank_reference_payment']);
        $payment->setIbanReference($iban->iban);
        $payment->setBicReference($iban->bic);
        $payment->setAmount($data['amount']);
        $payment->setReceivedAt($data['received_at']);
        $saved = $this->receivedPaymentRepository->save($payment);

        $payment_outbounds = $this->receivedPaymentRepository->getPaymentOutbounds($saved);
        foreach ($payment_outbounds as $payment_outbound) {
            $this->receivedPaymentOutboundInvoiceRepository->delete($payment_outbound);
        }

        foreach ($data['outbound_invoice'] as $id) {
            $outbound_invoice = $this->outboundInvoiceRepository->find($id);

            $relation = $this->receivedPaymentOutboundInvoiceRepository->make();
            $relation->setOutboundInvoice($outbound_invoice);
            $relation->setReceivedPayment($payment);
            $this->receivedPaymentOutboundInvoiceRepository->save($relation);
        }

        return $saved;
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

    private function checkIban($iban)
    {
        if (is_null($iban)) {
            throw new IbanNotFoundException();
        }
    }
}
