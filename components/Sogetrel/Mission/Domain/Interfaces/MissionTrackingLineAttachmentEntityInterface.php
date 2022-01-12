<?php

namespace Components\Sogetrel\Mission\Domain\Interfaces;

use Components\Common\Common\Domain\Interfaces\EntityInterface;
use Components\Common\Common\Domain\Interfaces\FileImmutableInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingLineEntityInterface;

interface MissionTrackingLineAttachmentEntityInterface extends EntityInterface
{
    const SEARCHABLE_ATTRIBUTE_NUM_ORDER = "num_order";
    const SEARCHABLE_ATTRIBUTE_NUM_ATTACHMENT = "num_attachment";
    const SEARCHABLE_ATTRIBUTE_VENDOR = "name";
    const SEARCHABLE_ATTRIBUTE_CUSTOMER = "customer_name";

    public function getTrackingLine(): TrackingLineEntityInterface;

    public function setTrackingLine(TrackingLineEntityInterface $milestone): self;

    public function getFile(): FileImmutableInterface;

    public function setFile(FileImmutableInterface $file): self;

    public function getAmount(): float;

    public function setAmount(float $amount): self;

    public function getSignedAt(): \DateTime;

    public function setSignedAt(\DateTime $signed_at): self;

    public function getSubmittedAt(): ?\DateTime;

    public function setSubmittedAt(?\DateTime $submitted_at): self;

    public function getReverseCharges(): bool;

    public function setReverseCharges(bool $reverse_charges): self;

    public function getDirectBilling(): bool;

    public function setDirectBilling(bool $direct_billing): self;

    public function getNumAttachment(): ?string;

    public function setNumAttachment(?string $num_attachment): self;

    public function getNumOrder(): ?string;

    public function setNumOrder(?string $num_order): self;

    public function getNumSite(): ?string;

    public function setNumSite(?string $num_site): self;

    public function scopeFilterInboundInvoice($query, $value);

    public function scopeFilterOutboundInvoice($query, $value);

    public function scopeFilterCustomer($query, $search, $operator);

    public function scopeFilterVendor($query, $search, $operator);
}
