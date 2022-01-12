<?php

namespace Tests\Unit\App\Repositories\Addworking\Mission;

use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\PurchaseOrder;
use App\Repositories\Addworking\Mission\MissionTrackingRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\User\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MissionTrackingRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider missionTrackingFormData
     */
    public function testCreateFromRequest($data)
    {
        $user = factory(User::class)->states('support')->create();
        $order = factory(PurchaseOrder::class)->states('draft')->create();
        $millestone = factory(Milestone::class)->create();

        $data['milestone'] = ["id" => $millestone->id];
        $request = new Request($data);

        $repo = $this->app->make(MissionTrackingRepository::class);

        $this->assertDatabaseMissing('addworking_mission_mission_trackings', $data['tracking']);

        $mission_tracking = $repo->createFromRequest($order->mission, $request);

        $this->assertTrue($mission_tracking->exists);
        $this->assertDatabaseHas('addworking_mission_mission_trackings', $data['tracking']);
    }

    public function missionTrackingFormData()
    {
        return [
            "mission_tracking" => [
                "data" => [
                    "tracking" => [
                        "description" => "une description",
                    ],
                    "line" => [
                        "label" => "Architecto repellendus ipsa magni dolor expedita quia dicta.",
                        "unit_price" => "10.1",
                        "unit" => "days",
                        "quantity" => "3",
                    ],
                ]
            ]
        ];
    }
}
