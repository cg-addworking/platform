<?php
namespace Components\Billing\PaymentOrder\Domain\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;

interface ModuleRepositoryInterface
{
    public function hasAccessToBilling(Enterprise $enterprise): bool;
}
