<?php

namespace Tests\Unit\App\Http\Controllers\Everial\Mission;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Everial\Mission\OfferController;
use App\Http\Requests\Addworking\Mission\Offer\StoreMissionOfferRequest;
use App\Models\Addworking\Common\Department;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\User\User;
use App\Models\Everial\Mission\Referential;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class OfferControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testConstruct()
    {
        $controller = $this->app->make(OfferController::class);

        $this->assertInstanceof(
            Controller::class,
            $controller
        );
    }

    public function testStore()
    {
        $controller  = $this->app->make(OfferController::class);
        $customer    = factory(Enterprise::class)->state('customer')->create();
        $department  = factory(Department::class)->create();
        $referential = factory(Referential::class)->create();
        $user        = factory(User::class)->create();

        $response = TestResponse::fromBaseResponse(
            $controller->store(
                $this->fakeRequest(StoreMissionOfferRequest::class)
                    ->setInputs([
                        'customer'      => ['id' => $customer->id],
                        'department'    => ['id' => $department->id],
                        'referential'   => ['id' => $referential->id],
                        'mission_offer' => [
                            'referent_id'       => $user->id,
                            'external_id'       => "1234",
                            'description'       => "Description",
                            'starts_at_desired' => "2020-01-01 00:00:00",
                            'ends_at'           => "2020-01-03 00:00:00",
                            'label'             => "Label",
                            'analytic_code'     => "D1120",
                        ]
                    ])
                    ->setFiles(
                        ['mission_offer' => ['file' => [$this->fakeFile('something.jpg')]]],
                    )
                    ->setUser($user)
                    ->obtain()
            )
        );

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas(
            (new Offer)->getTable(),
            [
                'customer_id'       => $customer->id,
                'created_by'        => $user->id,
                'referent_id'       => $user->id,
                'external_id'       => "1234",
                'description'       => "Description",
                'starts_at_desired' => "2020-01-01 00:00:00",
                'ends_at'           => "2020-01-03 00:00:00",
                'label'             => "Label",
                'analytic_code'     => "D1120 110",
            ]
        );
    }
}
