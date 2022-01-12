<?php

namespace Tests\Unit\App\Http\Controllers\Support\Mission;

use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class MissionTrackingLineControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexWithSupportUser()
    {
        $user = factory(User::class)->states('support')->create();
        $response = $this->actingAs($user)->get('/support/enterprise/mission/tracking/line');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testIndexWithNonSupportUser()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/support/enterprise/mission/tracking/line');

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testExport()
    {
        $user = factory(User::class)->states('support')->create();
        $response = $this->actingAs($user)->get('/support/enterprise/mission/tracking/line/export');

        $response->assertStatus(Response::HTTP_OK);
    }
}
