<?php

namespace Tests\Feature\App\Http\Controllers\Addworking\Mission;

use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Mission\ProposalRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProposalControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAccessingOfferIndexRoute()
    {
        $user = factory(User::class)->states('support')->create();

        $repository = $this->app->make(ProposalRepository::class);

        $this
            ->actingAs($user)
            ->get($repository->factory()->routes->index)
            ->assertStatus(200);
    }
}
