<?php

namespace Components\Mission\Mission\Domain\UseCases;

use Components\Mission\Mission\Domain\Interfaces\MissionEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingLineEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingLineRepositoryInterface;

class CreateTrackingLine
{
    protected $lines;

    public function __construct(TrackingLineRepositoryInterface $lines)
    {
        $this->lines = $lines;
    }

    public function handle(TrackingEntityInterface $tracking, array $data = []): TrackingLineEntityInterface
    {
        $data += [
            'unit' => MissionEntityInterface::UNIT_FIXED_FEES,
            'quantity' => 1,
            'unit_price' => 0,
            'validation_vendor' => TrackingLineEntityInterface::STATUS_PENDING,
            'validation_customer' => TrackingLineEntityInterface::STATUS_PENDING,
        ];

        $line = $this->lines->make()
            ->setTracking($tracking)
            ->setLabel($this->getLabel($data))
            ->setQuantity($this->getQuantity($data))
            ->setUnit($this->getUnit($data))
            ->setUnitPrice($this->getUnitPrice($data))
            ->setVendorValidationStatus($this->getVendorValidationStatus($data))
            ->setCustomerValidationStatus($this->getCustomerValidationStatus($data))
            ->setReasonForRejection($this->getReasonForRejection($data));

        if (! $this->lines->save($line)) {
            throw new \RuntimeException("unable to create new tracking");
        }

        return $line;
    }

    private function getLabel(array $data): ?string
    {
        return $data['label'] ?? null;
    }

    private function getQuantity(array $data): int
    {
        return $data['quantity'] ?? 1;
    }

    private function getUnit(array $data): string
    {
        if (! isset($data['unit'])) {
            throw new \RuntimeException("invalid data: missing key 'unit'");
        }

        return $this->validateUnit(
            $data['unit']
        );
    }

    private function validateUnit(string $unit): string
    {
        if (! in_array($unit, $units = $this->lines->make()->getAvailableUnits())) {
            throw new \UnexpectedValueException(
                "invalid unit: '{$unit}', ".
                "valid units are [".implode(',', $units)."]"
            );
        }

        return $unit;
    }

    private function getUnitPrice(array $data): float
    {
        return $data['unit_price'] ?? 0;
    }

    private function getVendorValidationStatus(array $data): ?string
    {
        if (! isset($data['validation_vendor'])) {
            return null;
        }

        return $this->validateStatus(
            $data['validation_vendor']
        );
    }

    private function getCustomerValidationStatus(array $data): ?string
    {
        if (! isset($data['validation_customer'])) {
            return null;
        }

        return $this->validateStatus(
            $data['validation_customer']
        );
    }

    private function validateStatus(string $status): string
    {
        if (! in_array($status, $statuses = $this->lines->make()->getAvailableStatuses())) {
            throw new \UnexpectedValueException(
                "invalid status: '{$status}', ".
                "valid statuses are [".implode(',', $statuses)."]"
            );
        }

        return $status;
    }

    private function getReasonForRejection(array $data): ?string
    {
        if (! isset($data['reason_for_rejection'])) {
            return null;
        }

        return $this->validateReasonForRejection(
            $data['reason_for_rejection']
        );
    }

    private function validateReasonForRejection(string $reason): string
    {
        if (! in_array($reason, $reasons = $this->lines->make()->getAvailableReasonForRejection())) {
            throw new \UnexpectedValueException(
                "invalid reason: '{$reason}', ".
                "valid reasons are [".implode(',', $reasons)."]"
            );
        }

        return $reason;
    }
}
