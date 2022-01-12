<?php
namespace Components\Billing\PaymentOrder\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Billing\PaymentOrder\Domain\Classes\PaymentOrderInterface;
use Components\Billing\PaymentOrder\Domain\Exceptions\IbanNotFoundException;
use Components\Billing\PaymentOrder\Domain\Exceptions\PaymentOrderNotFoundException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\Repositories\IbanRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\PaymentOrderRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EditPaymentOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $ibanRepository;
    private $paymentOrderRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        IbanRepositoryInterface $ibanRepository,
        PaymentOrderRepositoryInterface $paymentOrderRepository
    ) {
        $this->userRepository            = $userRepository;
        $this->ibanRepository            = $ibanRepository;
        $this->paymentOrderRepository    = $paymentOrderRepository;
    }

    public function handle(
        ?User $authUser,
        ?PaymentOrderInterface $paymentOrder,
        array $data
    ) {
        $this->checkUser($authUser);
        $this->checkPaymentOrder($paymentOrder);

        $iban = $this->ibanRepository->find($data['iban_id']);
        $this->checkIban($iban);

        $paymentOrder->setExecutedAt($data['executed_at']);
        $paymentOrder->setCustomerName($data['customer_name']);
        $paymentOrder->setStatus($data['status']);
        $paymentOrder->setBankReferencePayment($data['bank_reference_payment']);
        $paymentOrder->setIban($data['iban_id']);
        $paymentOrder->setDebtorName($iban->enterprise->name);
        $paymentOrder->setDebtorIban($iban->iban);
        $paymentOrder->setDebtorBic($iban->bic);

        return $this->paymentOrderRepository->save($paymentOrder);
    }

    private function checkUser($authUser)
    {
        if (is_null($authUser)) {
            throw new UserNotAuthentificatedException();
        }

        if (! $this->userRepository->isSupport($authUser)) {
            throw new UserIsNotSupportException();
        }
    }

    private function checkPaymentOrder($paymentOrder)
    {
        if (is_null($paymentOrder)) {
            throw new PaymentOrderNotFoundException();
        }
    }

    private function checkIban($iban)
    {
        if (is_null($iban)) {
            throw new IbanNotFoundException();
        }
    }
}
