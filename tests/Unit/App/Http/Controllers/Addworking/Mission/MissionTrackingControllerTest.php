<?php

namespace Tests\Unit\App\Http\Controllers\Addworking\Mission;

use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\PurchaseOrder;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MissionTrackingControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider missionTrackingFormData
     */
    public function testStore($data)
    {
        $user = factory(User::class)->states('support')->create();
        $milestone = factory(Milestone::class)->create();

        $data['milestone'] = ["id" => $milestone->id];

        $this->assertDatabaseMissing('addworking_mission_mission_trackings', $data['tracking']);

        $this->actingAs($user)->post(
            'mission/' . $milestone->mission->id . '/tracking',
            $data
        );

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
