<?php

namespace Components\Mission\Offer\Application\Repositories;

use Components\Mission\Mission\Application\Models\Mission;
use Components\Mission\Mission\Domain\Interfaces\Entities\MissionEntityInterface;
use Components\Mission\Offer\Application\Models\Response;
use Components\Mission\Offer\Domain\Interfaces\Repositories\MissionRepositoryInterface;

class MissionRepository implements MissionRepositoryInterface
{
    public function save(MissionEntityInterface $mission)
    {
        $mission->save();

        return $mission->refresh();
    }

    public function createFromResponse(Response $response)
    {
        $mission = new Mission;
        $mission->customer()->associate($response->getOffer()->getCustomer());
        $mission->vendor()->associate($response->getEnterprise());
        $mission->referent()->associate($response->getOffer()->getReferent());
        $mission->proposalResponse()->associate($response);
        $mission->setSectorOffer($response->getOffer());
        $mission->setWorkField($response->getOffer()->getWorkField());
        $mission->setAnalyticCode($response->getOffer()->getAnalyticCode());
        $mission->setExternalId($response->getOffer()->getExternalId());
        $mission->setAmount($response->getAmountBeforeTaxes());

        $mission->label = $response->getOffer()->getLabel().' - '
            .$response->getOffer()->getCustomer().' - '
            .$response->getEnterprise();
        
        $mission->starts_at = $response->getStartsAt();
        $mission->ends_at = $response->getEndsAt();
        $mission->status = Mission::STATUS_READY_TO_START;
        $mission->description = $response->getOffer()->getDescription();

        $mission->quantity = 1;
        $mission->unit_price = $response->getAmountBeforeTaxes();
        
        $mission->save();

        $mission->setDepartments($response->getOffer()->getDepartments()->pluck('id')->toArray());

        return $mission;
    }
}
