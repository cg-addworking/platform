<?php

namespace Components\Mission\Offer\Application\Repositories;

use App\Models\Addworking\Common\File;
use Components\Mission\Mission\Application\Models\CostEstimation;
use Components\Mission\Mission\Domain\Interfaces\Entities\CostEstimationEntityInterface;
use Components\Mission\Offer\Application\Models\Response;
use Components\Mission\Offer\Domain\Interfaces\Repositories\CostEstimationRepositoryInterface;

class CostEstimationRepository implements CostEstimationRepositoryInterface
{
    public function create($amount_before_taxes, $file)
    {
        $cost_estimation = new CostEstimation();
        if ($file) {
            $file = File::saveAndSendToStorage($file);
            $cost_estimation->setFile($file);
        }
        $cost_estimation->setAmountBeforeTaxes($amount_before_taxes);
        $cost_estimation->save();
        return $cost_estimation;
    }

    public function edit(CostEstimationEntityInterface $cost_estimation, $amount_before_taxes, $file)
    {
        if ($file) {
            $file = File::saveAndSendToStorage($file);
            $cost_estimation->setFile($file);
        }
        $cost_estimation->setAmountBeforeTaxes($amount_before_taxes);
        $cost_estimation->save();
        return $cost_estimation;
    }

    public function createFromResponse(Response $response)
    {
        $cost_estimation = new CostEstimation();
        $cost_estimation->setFile($response->getFile());
        $cost_estimation->setAmountBeforeTaxes($response->getAmountBeforeTaxes());
        $cost_estimation->save();
        return $cost_estimation;
    }
}
