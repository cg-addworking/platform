<?php

namespace Components\Enterprise\InvoiceParameter\Domain\Classes;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Enterprise\Enterprise;

interface CustomerBillingDeadlineInterface
{
    public function setEnterprise($enterprise): void;
    public function setDeadline($deadline): void;
    public function getEnterprise(): Enterprise;
    public function getDeadline(): DeadlineType;
}
