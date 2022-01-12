<?php

namespace Components\Sogetrel\Mission\Domain\UseCases;

use Components\Mission\Mission\Domain\Interfaces\TrackingLineEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingLineRepositoryInterface;
use Components\Sogetrel\Mission\Domain\Interfaces\MissionTrackingLineAttachmentEntityInterface;
use Components\Sogetrel\Mission\Domain\Interfaces\MissionTrackingLineAttachmentRepositoryInterface;

class CreateMissionTrackingLineAttachment
{
    private $enterprises;
    private $missons;
    private $milestones;
    private $attachments;
    private $lines;

    public function __construct(
        MissionTrackingLineAttachmentRepositoryInterface $attachments,
        TrackingLineRepositoryInterface $lines
    ) {
        $this->attachments = $attachments;
        $this->lines = $lines;
    }

    public function handle(TrackingLineEntityInterface $line, array $data): MissionTrackingLineAttachmentEntityInterface
    {
        $line
            ->setVendorValidationStatus(TrackingLineEntityInterface::STATUS_VALIDATED)
            ->setCustomerValidationStatus(TrackingLineEntityInterface::STATUS_VALIDATED);

        if (! $this->lines->save($line)) {
            throw new \RuntimeException("unable to update tracking line");
        }

        $attachment = $this->attachments->make()
            ->setTrackingLine($line)
            ->setAmount($this->getAmount($data))
            ->setSignedAt($this->getSignedAt($data))
            ->setSubmittedAt($this->getSubmittedAt($data))
            ->setReverseCharges($this->getReverseCharges($data))
            ->setDirectBilling($this->getDirectBilling($data))
            ->setNumAttachment($this->getNumAttachment($data))
            ->setNumOrder($this->getNumOrder($data))
            ->setNumSite($this->getNumSite($data));

        if (! $this->attachments->save($attachment)) {
            throw new \RuntimeException("unable to create new attachment");
        }

        return $attachment;
    }

    private function getAmount(array $data): float
    {
        if (! isset($data['amount'])) {
            throw new \RuntimeException(
                "invalid data: missing key 'amount'"
            );
        }

        return (float) $data['amount'];
    }

    private function getSignedAt(array $data): \DateTime
    {
        if (! isset($data['signed_at'])) {
            throw new \RuntimeException(
                "invalid data: missing key 'signed_at'"
            );
        }

        return new \DateTime($data['signed_at']);
    }

    private function getSubmittedAt(array $data): ?\DateTime
    {
        return isset($data['submitted_at']) ? new \DateTime($data['signed_at']) : null;
    }

    private function getReverseCharges(array $data): bool
    {
        return $data['reverse_charges'] ?? false;
    }

    private function getDirectBilling(array $data): bool
    {
        return $data['direct_billing'] ?? false;
    }

    private function getNumAttachment(array $data): ?string
    {
        return $data['num_attachment'] ?? null;
    }

    private function getNumOrder(array $data): ?string
    {
        return $data['num_order'] ?? null;
    }

    private function getNumSite(array $data): ?string
    {
        return $data['num_site'] ?? null;
    }
}
