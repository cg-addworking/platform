<?php

namespace Components\Mission\Mission\Domain\Interfaces;

use Components\Common\Common\Domain\Interfaces\EntityInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingEntityInterface;

interface TrackingLineEntityInterface extends EntityInterface
{
    public function getTracking(): TrackingEntityInterface;

    public function setTracking(TrackingEntityInterface $tracking): self;

    public function getLabel(): ?string;

    public function setLabel(?string $label): self;

    public function getQuantity(): int;

    public function setQuantity(int $quantity): self;

    public function getUnit(): string;

    public function setUnit(string $unit): self;

    public function getUnitPrice(): float;

    public function setUnitPrice(float $unit_price): self;

    public function getVendorValidationStatus(): ?string;

    public function setVendorValidationStatus(?string $status): self;

    public function getCustomerValidationStatus(): ?string;

    public function setCustomerValidationStatus(?string $status): self;

    public function getReasonForRejection(): ?string;

    public function setReasonForRejection(?string $reason): self;

    public static function getAvailableUnits(): array;

    const STATUS_PENDING = 'pending';
    const STATUS_VALIDATED = 'validated';
    const STATUS_REJECTED = 'rejected';

    public static function getAvailableStatuses(): array;

    const REJECTED_FOR_MISSION_NOT_REALIZED = "mission_not_realized";
    const REJECTED_FOR_MISSION_NOT_COMPLETED = "mission_not_completed";
    const REJECTED_FOR_ERROR_AMOUNT = "error_amount";
    const REJECTED_FOR_ERROR_QUANTITY = "error_quantity";
    const REJECTED_FOR_OTHER = "other";

    public static function getAvailableReasonForRejection(): array;
}
