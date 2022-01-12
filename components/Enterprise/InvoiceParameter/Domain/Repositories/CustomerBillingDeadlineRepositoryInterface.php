<?php

namespace Components\Enterprise\InvoiceParameter\Domain\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\InvoiceParameter\Application\Models\CustomerBillingDeadline;
use Components\Enterprise\InvoiceParameter\Domain\Classes\CustomerBillingDeadlineInterface;

interface CustomerBillingDeadlineRepositoryInterface
{
    public function make() : CustomerBillingDeadlineInterface;
    public function save(CustomerBillingDeadline $deadline): CustomerBillingDeadlineInterface;
    public function getDefaultDeadLinesOf(Enterprise $enterprise);
}
