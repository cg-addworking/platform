<?php

namespace Components\Mission\Mission\Domain\Interfaces;

use Components\Common\Common\Domain\Interfaces\EntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\EnterpriseEntityInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldEntityInterface;
use Components\Mission\Offer\Application\Models\Offer as SectorOffer;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;

interface MissionEntityInterface extends EntityInterface
{
    const UNIT_HOURS = 'hours';
    const UNIT_DAYS = 'days';
    const UNIT_FIXED_FEES = 'fixed_fees';
    const UNIT_UNIT = 'unit';

    const STATUS_DRAFT = 'draft';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_DONE = 'done';
    const STATUS_ABANDONED = 'abandoned';
    const STATUS_CLOSED = 'closed';
    const STATUS_READY_TO_START = 'ready_to_start';

    public function belongsToVendor(EnterpriseEntityInterface $enterprise): bool;
    public function setContract(ContractEntityInterface $contract): void;
    public function setSectorOffer(OfferEntityInterface $offer);
    public function setWorkField($value): void;
    public function setStartsAt($value): void;
    public function setEndsAt($value): void;

    public static function getAvailableUnits(): array;
    public static function getAvailableStatuses(): array;
    public function getContract(): ?ContractEntityInterface;
    public function getSectorOffer(): ?SectorOffer;
    public function getReferent();
    public function getWorkField(): ?WorkFieldEntityInterface;
    public function getStartsAt();
    public function getEndsAt();
}
