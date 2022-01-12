<?php

namespace Components\Enterprise\Resource\Domain\Classes;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\Resource\Domain\Classes\ResourceInterface;
use DateTime;

interface ActivityPeriodInterface
{
    public function getCustomer(): Enterprise;

    public function setCustomer(Enterprise $enterprise): void;

    public function getResource(): ResourceInterface;

    public function setResource(ResourceInterface $resource): void;

    public function getStartsAt(): DateTime;

    public function setStartsAt(DateTime $value): void;

    public function getEndsAt(): DateTime;

    public function setEndsAt(DateTime $value): void;

    public function save(array $options = []);
}
