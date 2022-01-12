<?php

namespace Tests\Unit\App\Http\Controllers\Addworking\Enterprise;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Support\Enterprise\LegalFormController;
use App\Models\Addworking\User\User;
use App\Models\Addworking\Enterprise\LegalForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LegalFormControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testConstruct()
    {
        $this->assertInstanceof(
            Controller::class,
            $this->app->make(LegalFormController::class),
            "The controller should be a controller"
        );
    }

    public function testIndex()
    {
        LegalForm::truncate();

        $legal_forms = factory(LegalForm::class, 5)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->get((new LegalForm)->routes->index);

        $response->assertOk();
        $response->assertViewIs('addworking.enterprise.legal_form.index');
        $response->assertViewHas('items');

        $items = $response->viewData('items');

        $this->assertEquals(5, $items->total(), "There should be 5 legal_forms in database");
    }

    public function testCreate()
    {
        LegalForm::truncate();

        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->get((new LegalForm)->routes->create);

        $response->assertOk();
        $response->assertViewIs('addworking.enterprise.legal_form.create');
    }

    public function testStore()
    {
        LegalForm::truncate();

        $data = factory(LegalForm::class)->make()->toArray();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->post((new LegalForm)->routes->store, ['legal_form' => $data]);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas((new LegalForm)->getTable(), $data);
    }

    public function testShow()
    {
        LegalForm::truncate();

        $legal_form = factory(LegalForm::class)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->get($legal_form->routes->show);

        $response->assertOk();
        $response->assertViewIs('addworking.enterprise.legal_form.show');
    }

    public function testEdit()
    {
        LegalForm::truncate();

        $legal_form = factory(LegalForm::class)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->get($legal_form->routes->edit);

        $response->assertOk();
        $response->assertViewIs('addworking.enterprise.legal_form.edit');
    }

    public function testUpdate()
    {
        LegalForm::truncate();

        $data = factory(LegalForm::class)->make()->toArray();
        $legal_form = factory(LegalForm::class)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->put($legal_form->routes->update, ['legal_form' => $data]);

        $this->assertDatabaseHas((new LegalForm)->getTable(), $data);
    }

    public function testDestroy()
    {
        LegalForm::truncate();

        $legal_form = factory(LegalForm::class)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->delete($legal_form->routes->destroy);

        $this->assertDatabaseMissing((new LegalForm)->getTable(), $legal_form->toArray());
    }
}
