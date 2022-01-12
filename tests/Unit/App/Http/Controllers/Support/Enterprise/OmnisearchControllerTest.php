<?php

namespace Tests\Unit\App\Http\Controllers\Support\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OmnisearchControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        // only support should be able to use omnisearch
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/support/omnisearch');
        $response->assertStatus(403);
    }

    public function testIndexWithSupportUser()
    {
        $user = factory(User::class)->state('support')->create();

        $response = $this->actingAs($user)->get('/support/omnisearch');
        $response->assertStatus(200);
        $response->assertViewIs('support.enterprise.omnisearch.index');
    }

    public function testSearch()
    {
        // only support should be able to use omnisearch
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/support/omnisearch', ['search' =>  123]);
        $response->assertStatus(403);
    }

    public function testSearchWithSupportUser()
    {
        $user = factory(User::class)->state('support')->create();

        $enterprise = factory(Enterprise::class)->create(['name' => "foobar"]);

        $response = $this->actingAs($user)->post('/support/omnisearch', ['search' => "foobar"]);
        $response->assertStatus(200);
        $response->assertViewIs('support.enterprise.omnisearch.index');
        $response->assertViewHas('models', function ($models) use ($enterprise) {
            return $models->contains($enterprise);
        });
    }
}
