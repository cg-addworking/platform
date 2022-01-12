<?php

namespace Components\Mission\Offer\Domain\Interfaces\Repositories;

use Components\Mission\Mission\Domain\Interfaces\Entities\CostEstimationEntityInterface;
use Components\Mission\Offer\Application\Models\Response;

interface CostEstimationRepositoryInterface
{
    public function create($amount_before_taxes, $file);
    public function edit(CostEstimationEntityInterface $cost_estimation, $amount_before_taxes, $file);
    public function createFromResponse(Response $response);
}
