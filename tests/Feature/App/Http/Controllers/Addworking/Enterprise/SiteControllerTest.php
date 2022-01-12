<?php

namespace Tests\Feature\App\Http\Controllers\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Site;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $site;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->state('support')->create();
        $this->site = factory(Site::class)->create();
    }

    public function testAccessingSiteIndexRoute()
    {
        $this
            ->get($this->site->routes->index)
            ->assertRedirect('login');

        $response = $this
            ->actingAs($this->user)
            ->get($this->site->routes->index)
            ->assertViewIs('addworking.enterprise.site.index')
            ->assertStatus(200);
    }

    public function testAccessingSiteCreateRoute()
    {
        $this
            ->get($this->site->routes->create)
            ->assertRedirect('login');

        $this
            ->actingAs($this->user)
            ->get($this->site->routes->create)
            ->assertViewIs('addworking.enterprise.site.create')
            ->assertStatus(200);
    }

    public function testAccessingSiteShowRoute()
    {
        $this
            ->get($this->site->routes->show)
            ->assertRedirect('login');

        $this
            ->actingAs($this->user)
            ->get($this->site->routes->show)
            ->assertViewIs('addworking.enterprise.site.show')
            ->assertStatus(200);
    }

    public function testAccessingSiteEditRoute()
    {
        $this
            ->get($this->site->routes->edit)
            ->assertRedirect('login');

        $this
            ->actingAs($this->user)
            ->get($this->site->routes->edit)
            ->assertViewIs('addworking.enterprise.site.edit')
            ->assertStatus(200);
    }
}
