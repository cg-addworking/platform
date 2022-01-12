<?php

namespace Components\Enterprise\BusinessTurnover\Application\Repositories;

use Components\Enterprise\BusinessTurnover\Domain\Exceptions\BusinessTurnoverCreationFailedException;
use Components\Enterprise\BusinessTurnover\Domain\Interfaces\Entities\BusinessTurnoverEntityInterface;
use Components\Enterprise\BusinessTurnover\Domain\Interfaces\Repositories\BusinessTurnoverRepositoryInterface;
use Components\Enterprise\BusinessTurnover\Application\Models\BusinessTurnover;

class BusinessTurnoverRepository implements BusinessTurnoverRepositoryInterface
{
    public function make($data = []): BusinessTurnoverEntityInterface
    {
        return new BusinessTurnover($data);
    }

    public function save(BusinessTurnoverEntityInterface $business_turnover): BusinessTurnoverEntityInterface
    {
        try {
            $business_turnover->save();
        } catch (BusinessTurnoverCreationFailedException $exception) {
            throw $exception;
        }

        $business_turnover->refresh();

        return $business_turnover;
    }
}
