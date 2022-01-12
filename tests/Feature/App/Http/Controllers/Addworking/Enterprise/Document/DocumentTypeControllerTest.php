<?php

namespace Tests\Feature\App\Http\Controllers\Addworking\Enterprise\Document;

use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentTypeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $documentType;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->state('support')->create();
        $this->documentType = factory(DocumentType::class)->create();
    }

    public function testAccessingDocumentTypeIndexRoute()
    {
        $this
            ->get($this->documentType->routes->index)
            ->assertRedirect('login');

        $this
            ->actingAs($this->user)
            ->get($this->documentType->routes->index)
            ->assertViewIs('addworking.enterprise.document_type.index')
            ->assertStatus(200);
    }

    public function testAccessingDocumentTypeCreateRoute()
    {
        $this
            ->get($this->documentType->routes->create)
            ->assertRedirect('login');

        $this
            ->actingAs($this->user)
            ->get($this->documentType->routes->create)
            ->assertViewIs('addworking.enterprise.document_type.create')
            ->assertStatus(200);
    }

    public function testAccessingDocumentTypeShowRoute()
    {
        $this
            ->get($this->documentType->routes->show)
            ->assertRedirect('login');

        $this
            ->actingAs($this->user)
            ->get($this->documentType->routes->show)
            ->assertViewIs('addworking.enterprise.document_type.show')
            ->assertStatus(200);
    }
}
