<?php

namespace Components\Enterprise\Enterprise\Domain\Interfaces\Entities;

interface CompanyActivityEntityInterface
{
    public function getActivity();
    public function getSocialObject(): ?string;
    public function getStartsAt();
    public function getEndsAt();
    public function getOriginData(): ?string;
}
