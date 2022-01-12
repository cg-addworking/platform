<?php

namespace Tests\Unit\App\Repositories\Addworking\Billing;

use App\Models\Addworking\Billing\VatRate;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Billing\VatRateRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class VatRateRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateFromRequest()
    {
        $user = factory(User::class)->states('support')->create();

        $response = $this->actingAs($user)->post((new VatRate)->routes->store, [
            'vat_rate' => [
                'display_name' => "Foobar",
                'value'        => 80,
                'description'  => "Lorem ipsum dolor sit amet, consectetur adipisicing elit.",
            ]
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas(
            (new VatRate)->getTable(),
            [
                'display_name' => "Foobar",
                'value'        => .8,
                'description'  => "Lorem ipsum dolor sit amet, consectetur adipisicing elit.",
            ]
        );
    }

    public function testUpdateFromRequest()
    {
        $user = factory(User::class)->states('support')->create();

        $vat_rate = factory(VatRate::class)->create();

        $response = $this->actingAs($user)->put($vat_rate->routes->update, [
            'vat_rate' => [
                'display_name' => "Barbaz",
                'value'        => 60,
                'description'  => "Ea quam recusandae voluptates molestiae eveniet tenetur dignissimos",
            ]
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas(
            (new VatRate)->getTable(),
            [
                'id'           => $vat_rate->id,
                'display_name' => "Barbaz",
                'value'        => .6,
                'description'  => "Ea quam recusandae voluptates molestiae eveniet tenetur dignissimos",
            ]
        );
    }
}
