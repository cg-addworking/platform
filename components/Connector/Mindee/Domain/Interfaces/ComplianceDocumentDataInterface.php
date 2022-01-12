<?php

namespace Components\Connector\Mindee\Domain\Interfaces;

use Carbon\Carbon;

interface ComplianceDocumentDataInterface
{
    public function getSecurityCode();
    public function getDateValidFrom(): ?Carbon;
}
