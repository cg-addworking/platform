<?php

namespace Tests\Unit\App\Repositories\Addworking\Common;

use App\Models\Addworking\Common\Address;
use App\Repositories\Addworking\Common\AddressRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $repo = app(AddressRepository::class);
        $address = factory(Address::class)->make();

        $this->assertTrue($repo->create($address->toArray()) instanceof Address);
    }
}
