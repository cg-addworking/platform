<?php

namespace Components\Enterprise\BusinessTurnover\Domain\Interfaces\Repositories;

use Components\Enterprise\BusinessTurnover\Domain\Interfaces\Entities\BusinessTurnoverEntityInterface;

interface BusinessTurnoverRepositoryInterface
{
    public function make($data = []): BusinessTurnoverEntityInterface;
    public function save(BusinessTurnoverEntityInterface $business_turnover): BusinessTurnoverEntityInterface;
}
