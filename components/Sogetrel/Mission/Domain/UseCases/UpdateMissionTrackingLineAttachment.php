<?php

namespace Components\Sogetrel\Mission\Domain\UseCases;

use Components\Mission\Mission\Domain\Interfaces\TrackingLineEntityInterface;
use Components\Sogetrel\Mission\Domain\Interfaces\MissionTrackingLineAttachmentEntityInterface;
use Components\Sogetrel\Mission\Domain\Interfaces\MissionTrackingLineAttachmentRepositoryInterface;

class UpdateMissionTrackingLineAttachment
{
    private $enterprises;
    private $missons;
    private $milestones;
    private $attachments;

    public function __construct(MissionTrackingLineAttachmentRepositoryInterface $attachments)
    {
        $this->attachments = $attachments;
    }

    public function handle(MissionTrackingLineAttachmentEntityInterface $attachment, array $data): bool
    {
        if (isset($data['amount'])) {
            $attachment->setAmount($data['amount']);
        }

        if (isset($data['signed_at'])) {
            $attachment->setSignedAt(new \DateTime($data['signed_at']));
        }

        if (isset($data['reverse_charges'])) {
            $attachment->setReverseCharges((bool) $data['reverse_charges']);
        }

        if (isset($data['direct_billing'])) {
            $attachment->setDirectBilling((bool) $data['direct_billing']);
        }

        if (isset($data['num_attachment'])) {
            $attachment->setNumAttachment($data['num_attachment']);
        }

        if (isset($data['num_order'])) {
            $attachment->setNumOrder($data['num_order']);
        }

        if (isset($data['num_site'])) {
            $attachment->setNumSite($data['num_site']);
        }

        return $this->attachments->save($attachment);
    }
}
