<?php
namespace Components\Billing\PaymentOrder\Domain\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Billing\PaymentOrder\Application\Models\ReceivedPayment;
use Components\Billing\PaymentOrder\Domain\Classes\ReceivedPaymentInterface;

interface ReceivedPaymentRepositoryInterface
{
    public function save(ReceivedPaymentInterface $payment);
    public function list(Enterprise $enterprise);
    public function listAsSupport();
    public function make($data = []): ReceivedPayment;
    public function findByNumber(string $number);
    public function getPaymentOutbounds(ReceivedPaymentInterface $received_payment);
    public function getOutboundInvoices(ReceivedPaymentInterface $received_payment);
    public function delete(?ReceivedPayment $received_payment);
    public function findTrashedByNumber(string $number);
}
