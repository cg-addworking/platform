<?php

namespace Components\Common\Common\Domain\Interfaces\Entities;

interface CountryEntityInterface
{
    const CODE_FRANCE      = 'fr';
    const CODE_DEUTSCHLAND = 'de';
    const CODE_BELGIUM     = 'be';

    const NAME_FRANCE       = "France";
    const NAME_DEUTSCHLAND  = "Deutschland";
    const NAME_BELGIUM      = "Belgium";

    public function getCode();
}
