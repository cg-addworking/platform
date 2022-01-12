<?php

namespace Tests\Unit\App\Models\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    use RefreshDatabase;

    public function testScopeOnlyPending()
    {
        $documents = factory(Document::class, 5)->state('pending')->create();

        $this->assertEquals(
            5,
            Document::onlyPending()->count(),
            "There should be only 5 documents with 'pending' status"
        );
    }

    public function testScopeOnlyValidated()
    {
        $documents = factory(Document::class, 5)->state('validated')->create();

        $this->assertEquals(
            5,
            Document::onlyValidated()->count(),
            "There should be only 5 documents with 'validated' status"
        );
    }

    public function testScopeOnlyRejected()
    {
        $documents = factory(Document::class, 5)->state('rejected')->create();

        $this->assertEquals(
            5,
            Document::onlyRejected()->count(),
            "There should be only 5 documents with 'rejected' status"
        );
    }

    public function testScopeOnlyOutdated()
    {
        $documents = factory(Document::class, 5)->state('outdated')->create();

        $this->assertEquals(
            5,
            Document::onlyOutdated()->count(),
            "There should be only 5 documents with 'outdated' status"
        );
    }

    public function testScopeSearch()
    {
        $document = factory(Document::class)->create();
        $document->enterprise->update(['name' => "VENDOR"]);
        $document->documentType->enterprise->update(['name' => "CUSTOMER"]);

        $this->assertEquals(
            0,
            Document::search('foo')->count(),
            'We should find 0 document by this search term'
        );

        $this->assertEquals(
            1,
            Document::search('NDO')->count(),
            'We should find the document by enterprise name'
        );

        $this->assertEquals(
            1,
            Document::search('UST')->count(),
            'We should find the document by customer name'
        );
    }
}
