<?php
namespace Components\Billing\PaymentOrder\Domain\Repositories;

use Components\Billing\PaymentOrder\Domain\Classes\PaymentOrderInterface;

interface PaymentOrderFileRepositoryInterface
{
    public function generate(PaymentOrderInterface $payment_order);
}
