<?php

namespace Tests\Unit\App\Models\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentCollection;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use stdClass;

class DocumentCollectionTest extends TestCase
{
    use RefreshDatabase;

    public function testViews()
    {
        $document_collection = factory(Document::class, 5)->create();

        $this->assertTrue(
            in_array(Viewable::class, trait_uses_recursive(DocumentCollection::class)),
            "The 'DocumentCollection' class should have equiped the 'Viewable' trait"
        );

        $this->assertNotNull(
            $document_collection->views(),
            "DocumentCollection should be able to generate its views"
        );

        $this->assertInstanceOf(
            Renderable::class,
            $document_collection->views()->status,
            "DocumentCollection should have a status view"
        );
    }

    public function testFilterStatus()
    {
        $statuses = Document::getAvailableStatuses();

        foreach ($statuses as $status) {
            factory(Document::class)->create(@compact('status'));
        }

        foreach ($statuses as $status) {
            $this->assertCount(
                1,
                Document::get()->filterStatus($status),
                "There should be exactly 1 documents with 'filterStatus' status in the collection"
            );
        }
    }

    public function testOnlyValidated()
    {
        factory(Document::class, 5)->state('validated')->create();

        $this->assertCount(
            5,
            Document::get()->onlyValidated(),
            "There should be exactly 5 documents with 'validated' status in the collection"
        );
    }

    public function testOnlyPending()
    {
        factory(Document::class, 5)->state('pending')->create();

        $this->assertCount(
            5,
            Document::get()->onlyPending(),
            "There should be exactly 5 documents with 'pending' status in the collection"
        );
    }

    public function testOnlyOutdated()
    {
        factory(Document::class, 5)->state('outdated')->create();

        $this->assertCount(
            5,
            Document::get()->onlyOutdated(),
            "There should be exactly 5 documents with 'outdated' status in the collection"
        );
    }

    public function testOnlyRejected()
    {
        factory(Document::class, 5)->state('rejected')->create();

        $this->assertCount(
            5,
            Document::get()->onlyRejected(),
            "There should be exactly 5 documents with 'rejected' status in the collection"
        );
    }

    public function testValidated()
    {
        factory(Document::class)->state('validated')->create();
        factory(Document::class, 5)->state('pending')->create();

        $this->assertTrue(
            Document::get()->validated(),
            "There should be at least one document with 'validated' status in the collection"
        );
    }

    public function testPending()
    {
        factory(Document::class)->state('pending')->create();
        factory(Document::class, 5)->state('validated')->create();

        $this->assertTrue(
            Document::get()->pending(),
            "There should be at least one document with 'pending' status in the collection"
        );
    }

    public function testOutdated()
    {
        factory(Document::class)->state('outdated')->create();
        factory(Document::class, 5)->state('pending')->create();

        $this->assertTrue(
            Document::get()->outdated(),
            "There should be at least one document with 'outdated' status in the collection"
        );
    }

    public function testRejected()
    {
        factory(Document::class)->state('rejected')->create();
        factory(Document::class, 5)->state('pending')->create();

        $this->assertTrue(
            Document::get()->rejected(),
            "There should be at least one document with 'rejected' status in the collection"
        );
    }
}
