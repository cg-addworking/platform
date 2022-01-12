<?php

namespace Tests\Unit\App\Http\Controllers\Addworking\Common;

use App\Http\Controllers\Addworking\Common\PassworkController;
use App\Http\Requests\Addworking\Common\Passwork\StorePassworkRequest;
use App\Models\Addworking\Common\Passwork;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class PassworkControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        $controller = $this->app->make(PassworkController::class);
        $customer   = factory(Enterprise::class)->state('customer')->create();
        $vendor     = factory(Enterprise::class)->state('vendor')->create();
        $user       = $vendor->users()->first();

        $customer->vendors()->attach($vendor);

        $response = TestResponse::fromBaseResponse(
            $controller->store(
                $this->fakeRequest(StorePassworkRequest::class)
                    ->setInputs([
                        'customer' => [
                            'id' => $customer->id
                        ]
                    ])
                    ->setUser($user)
                    ->obtain(),
                $vendor
            )
        );

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas(
            (new Passwork())->getTable(),
            [
                'customer_id'       => $customer->id,
            ]
        );
    }
}
