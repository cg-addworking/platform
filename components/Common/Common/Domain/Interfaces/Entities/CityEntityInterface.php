<?php

namespace Components\Common\Common\Domain\Interfaces\Entities;

interface CityEntityInterface
{
    public function getName(): string;
    public function getZipCode(): string;
}
