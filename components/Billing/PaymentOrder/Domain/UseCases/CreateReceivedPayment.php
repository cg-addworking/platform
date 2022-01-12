<?php

namespace Components\Billing\PaymentOrder\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Billing\PaymentOrder\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\PaymentOrder\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Billing\PaymentOrder\Domain\Exceptions\EnterpriseNotExistsException;
use Components\Billing\PaymentOrder\Domain\Exceptions\IbanNotFoundException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\PaymentOrder\Domain\Repositories\IbanRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\OutboundInvoiceRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\ReceivedPaymentOutboundInvoiceRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\ReceivedPaymentRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\UserRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\ModuleRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateReceivedPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $ibanRepository;
    private $receivedPaymentRepository;
    private $enterpriseRepository;
    private $moduleRepository;
    private $outboundInvoiceRepository;
    private $receivedPaymentOutboundInvoiceRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        IbanRepositoryInterface $ibanRepository,
        ReceivedPaymentRepositoryInterface $receivedPaymentRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        ModuleRepositoryInterface $moduleRepository,
        OutboundInvoiceRepositoryInterface $outboundInvoiceRepository,
        ReceivedPaymentOutboundInvoiceRepositoryInterface $receivedPaymentOutboundInvoiceRepository
    ) {
        $this->userRepository            = $userRepository;
        $this->ibanRepository            = $ibanRepository;
        $this->receivedPaymentRepository = $receivedPaymentRepository;
        $this->enterpriseRepository      = $enterpriseRepository;
        $this->moduleRepository          = $moduleRepository;
        $this->outboundInvoiceRepository = $outboundInvoiceRepository;
        $this->receivedPaymentOutboundInvoiceRepository = $receivedPaymentOutboundInvoiceRepository;
    }

    public function handle(?User $auth_user, ?Enterprise $enterprise, $data)
    {
        $this->checkUser($auth_user);
        $this->checkEnterprise($enterprise);

        $iban = $this->ibanRepository->find($data['iban']);

        $this->checkIban($iban);
        $received_payment = $this->receivedPaymentRepository->make();
        $received_payment->setEnterprise($enterprise);
        $received_payment->setIban($iban);
        $received_payment->setCreatedBy($auth_user);
        $received_payment->setNumber();
        $received_payment->setBankReferencePayment($data['bank_reference_payment']);
        $received_payment->setIbanReference($iban->iban);
        $received_payment->setBicReference($iban->bic);
        $received_payment->setAmount($data['amount']);
        $received_payment->setReceivedAt($data['received_at']);
        $payment = $this->receivedPaymentRepository->save($received_payment);

        foreach ($data['outbound_invoice'] as $id) {
            $outbound_invoice = $this->outboundInvoiceRepository->find($id);

            $relation = $this->receivedPaymentOutboundInvoiceRepository->make();
            $relation->setOutboundInvoice($outbound_invoice);
            $relation->setReceivedPayment($payment);
            $this->receivedPaymentOutboundInvoiceRepository->save($relation);
        }

        return $received_payment;
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

    private function checkIban($iban)
    {
        if (is_null($iban)) {
            throw new IbanNotFoundException();
        }
    }
}
