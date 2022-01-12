<?php

namespace Tests\Feature\App\Http\Controllers\Addworking\Enterprise\Document;

use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $document;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'is_system_superadmin'  => true,
            'is_system_admin'       => true,
            'is_system_operator'    => true,
        ]);

        $this->document = factory(Document::class)->create();
    }

    public function testAccessingDocumentIndexRoute()
    {
        $this
            ->get($this->document->routes->index)
            ->assertRedirect('login');

        $this
            ->actingAs($this->user)
            ->get($this->document->routes->index)
            ->assertViewIs('addworking.enterprise.document.index')
            ->assertStatus(200);
    }

    public function testAccessingDocumentShowRoute()
    {
        $this
            ->get($this->document->routes->show)
            ->assertRedirect('login');

        $this
            ->actingAs($this->user)
            ->get($this->document->routes->show)
            ->assertViewIs('addworking.enterprise.document.show')
            ->assertStatus(200);
    }
}
