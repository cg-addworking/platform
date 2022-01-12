<?php
namespace Components\Billing\Outbound\Domain\Repositories;

interface AddressRepositoryInterface
{
    public function find(string $id);
}
