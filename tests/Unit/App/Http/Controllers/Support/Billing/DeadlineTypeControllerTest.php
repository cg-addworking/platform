<?php

namespace Tests\Unit\App\Http\Controllers\Support\Billing;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Support\Billing\DeadlineTypeController;
use App\Models\Addworking\User\User;
use App\Models\Addworking\Billing\DeadlineType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeadlineTypeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testConstruct()
    {
        $this->assertInstanceof(
            Controller::class,
            $this->app->make(DeadlineTypeController::class),
            "The controller should be a controller"
        );
    }

    public function testIndex()
    {
        $deadline_types = factory(DeadlineType::class, 5)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->get((new DeadlineType)->routes->index);

        $response->assertOk();
        $response->assertViewIs('support.billing.deadline_type.index');
        $response->assertViewHas('items');

        $items = $response->viewData('items');

        $this->assertEquals(5, $items->total(), "There should be 5 deadline_types in database");
    }

    public function testCreate()
    {
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->get((new DeadlineType)->routes->create);

        $response->assertOk();
        $response->assertViewIs('support.billing.deadline_type.create');
    }

    public function testStore()
    {
        $data = factory(DeadlineType::class)->make()->toArray();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->post((new DeadlineType)->routes->store, ['deadline_type' => $data]);

        $this->assertDatabaseHas((new DeadlineType)->getTable(), $data);
    }

    public function testShow()
    {
        $deadline_type = factory(DeadlineType::class)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->get($deadline_type->routes->show);

        $response->assertOk();
        $response->assertViewIs('support.billing.deadline_type.show');
    }

    public function testEdit()
    {
        $deadline_type = factory(DeadlineType::class)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->get($deadline_type->routes->edit);

        $response->assertOk();
        $response->assertViewIs('support.billing.deadline_type.edit');
    }

    public function testUpdate()
    {
        $data = factory(DeadlineType::class)->make()->toArray();
        $deadline_type = factory(DeadlineType::class)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->put($deadline_type->routes->update, ['deadline_type' => $data]);

        $this->assertDatabaseHas((new DeadlineType)->getTable(), $data);
    }

    public function testDestroy()
    {
        $deadline_type = factory(DeadlineType::class)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->delete($deadline_type->routes->destroy);

        $this->assertDatabaseMissing((new DeadlineType)->getTable(), [
            'deleted_at' => $deadline_type->deleted_at,
        ]);
    }
}
