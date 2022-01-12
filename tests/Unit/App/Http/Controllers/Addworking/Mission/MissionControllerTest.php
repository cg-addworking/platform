<?php

namespace Tests\Unit\App\Http\Controllers\Addworking\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class MissionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testClose()
    {
        $user = factory(User::class)->states('support')->create();
        $mission = factory(Mission::class)->states('status_in_progress')->create();

        $response = $this->actingAs($user)->get('/mission/'.$mission->id.'/close');
        $response->assertStatus(302);
        $response->assertRedirect(route('mission.tracking.create', $mission));
    }
}
