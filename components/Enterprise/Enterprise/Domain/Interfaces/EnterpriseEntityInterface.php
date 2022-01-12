<?php

namespace Components\Enterprise\Enterprise\Domain\Interfaces;

use Components\Common\Common\Domain\Interfaces\EntityInterface;

interface EnterpriseEntityInterface extends EntityInterface
{
    public function isCustomer(): bool;

    public function isVendor(): bool;

    public function isVendorOf(self $customer, bool $including_subsidiaries = false): bool;
}
