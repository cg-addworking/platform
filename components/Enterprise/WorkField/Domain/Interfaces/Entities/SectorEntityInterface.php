<?php

namespace Components\Enterprise\WorkField\Domain\Interfaces\Entities;

interface SectorEntityInterface
{
    public function getDisplayName(): string;
    public function getName(): string;
    public function getNumber(): string;
}
