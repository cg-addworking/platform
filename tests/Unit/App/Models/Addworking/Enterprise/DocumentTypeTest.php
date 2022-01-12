<?php

namespace Tests\Unit\App\Models\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DocumentTypeTest extends TestCase
{
    use RefreshDatabase;

    public function testToString()
    {
        $type = factory(DocumentType::class)->create(['display_name' => "foobar"]);

        $this->assertEquals(
            "foobar",
            (string) $type
        );

        $type = new DocumentType;

        $this->assertEquals(
            "n/a",
            (string) $type
        );
    }

    public function testScopeOfType()
    {
        factory(DocumentType::class, 5)->state('legal')->create();

        $this->assertEquals(
            5,
            DocumentType::ofType(DocumentType::TYPE_LEGAL)->count(),
            "There should be only 5 document_type with 'legal' type"
        );
    }

    public function testScopeExceptType()
    {
        factory(DocumentType::class, 2)->state('legal')->create();

        factory(DocumentType::class, 3)->state('business')->create();

        factory(DocumentType::class, 4)->state('informative')->create();


        $this->assertEquals(
            5,
            DocumentType::exceptType(DocumentType::TYPE_INFORMATIVE)->count(),
            "We should count only 5 document_types which are not of type informative"
        );
    }

    public function testScopeOfEnterprise()
    {
        $document_type = factory(DocumentType::class)->state('legal')->create();

        $this->assertEquals(
            1,
            DocumentType::ofEnterprise($document_type->enterprise)->count(),
            "There should be only 1 document_type with '{$document_type->enterprise->id}' enterprise"
        );
    }

    public function testScopeOfEnterprises()
    {
        $document_type_1 = factory(DocumentType::class)->state('legal')->create();
        $document_type_2 = factory(DocumentType::class)->state('legal')->create();

        $this->assertEquals(
            2,
            DocumentType::ofEnterprises($document_type_1->enterprise, $document_type_2->enterprise)->count(),
            "There should be only 2 document types for this enterprises"
        );
    }

    public function testScopeMandatory()
    {
        factory(DocumentType::class, 5)->state('is_mandatory')->create();

        $this->assertEquals(
            5,
            DocumentType::mandatory()->count(),
            "There should be only 5 mandatory document type"
        );
    }
}
