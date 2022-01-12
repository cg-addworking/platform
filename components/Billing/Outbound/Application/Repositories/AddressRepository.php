<?php
namespace Components\Billing\Outbound\Application\Repositories;

use App\Models\Addworking\Common\Address;
use Components\Billing\Outbound\Domain\Repositories\AddressRepositoryInterface;

class AddressRepository implements AddressRepositoryInterface
{
    public function find(string $id)
    {
        return Address::where('id', $id)->first();
    }
}
