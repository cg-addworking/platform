<?php

namespace Components\Enterprise\Enterprise\Domain\Interfaces\Entities;

interface ActivityEntityInterface
{
    public function getSector();
    public function getCode(): ?string;
    public function getName(): ?string;
    public function getDomaine(): ?string;
}
