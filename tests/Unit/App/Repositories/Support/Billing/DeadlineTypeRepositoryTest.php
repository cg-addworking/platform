<?php

namespace Tests\Unit\App\Repositories\Support\Billing;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeadlineTypeRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateFromRequest()
    {
        $user = factory(User::class)->states('support')->create();

        $response = $this->actingAs($user)->post((new DeadlineType)->routes->store, [
            'deadline_type' => [
                'display_name' => "Foobar",
                'value'        => 30,
                'description'  => "Lorem ipsum dolor sit amet, consectetur adipisicing elit.",
            ]
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas(
            (new DeadlineType)->getTable(),
            [
                'display_name' => "Foobar",
                'value'        => 30,
                'description'  => "Lorem ipsum dolor sit amet, consectetur adipisicing elit.",
            ]
        );
    }

    public function testUpdateFromRequest()
    {
        $user = factory(User::class)->states('support')->create();

        $deadline_type = factory(DeadlineType::class)->create();

        $response = $this->actingAs($user)->put($deadline_type->routes->update, [
            'deadline_type' => [
                'display_name' => "BarbazOo",
                'value'        => 60,
                'description'  => "Ea quam recusandae voluptates molestiae eveniet tenetur dignissimos",
            ]
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas(
            (new DeadlineType)->getTable(),
            [
                'id'           => $deadline_type->id,
                'display_name' => "BarbazOo",
                'value'        => 60,
                'description'  => "Ea quam recusandae voluptates molestiae eveniet tenetur dignissimos",
            ]
        );
    }
}
