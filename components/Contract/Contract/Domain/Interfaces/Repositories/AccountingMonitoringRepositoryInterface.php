<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use App\Models\Addworking\User\User;

interface AccountingMonitoringRepositoryInterface
{
    public function list(User $user);
    public function getSearchableAttributes(): array;
    public function getWorkfieldName($contract);
    public function getVendor($contract);
    public function getSignature($contract);
    public function getGuaranteedHoldback($contract);
    public function getGuaranteedHoldbackAmount($contract);
    public function getGuaranteedHoldbackDepositNumber($contract);
    public function getGoodEnd($contract);
    public function getGoodEndAmount($contract);
    public function getGoodEndDeposit($contract);
    public function getAmountBeforeTaxes($contract);
    public function getAmountBeforeTaxesInvoiced($contract);
    public function getAmountOfTaxesInvoiced($contract);
    public function getAmountOfRemainsToBeBilled($contract);
    public function getPayment($contract);
}
