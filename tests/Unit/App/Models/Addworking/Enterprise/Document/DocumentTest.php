<?php

namespace Tests\Unit\App\Models\Addworking\Enterprise\Document;

use App\Events\Addworking\Enterprise\Document\DocumentCreated;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    use RefreshDatabase;

    public function testGetStoragePath()
    {
        $doc = factory(Document::class)->create();

        $uuid   = "[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}";
        $regexp = "#^({$uuid})/({$uuid})/({$uuid}).\w+$#";

        $this->assertRegExp(
            $regexp,
            $path = $doc->getStoragePath(),
            "The storage path for document should follow format 'vendor_id/type_id/doc_id.ext'"
        );

        preg_match($regexp, $path, $matches);
        list(, $vendor, $type, $doc) = $matches;

        $this->assertTrue(Enterprise::where('id', $vendor)->exists());
        $this->assertTrue(DocumentType::where('id', $type)->exists());
        $this->assertTrue(Document::where('id', $doc)->exists());
    }

    public function testSendToStorage()
    {
        Storage::fake('fake_documents_s3');

        // it's disabled by default (for a VERY good reason)
        // in phpunit.xml so we set it manually here.
        Config::set('documents.storage.enabled', true);
        Config::set('documents.storage.disk', 'fake_documents_s3');

        $document = factory(Document::class)->create();

        event(new DocumentCreated($document));

        Storage::disk('fake_documents_s3')->assertExists($document->getStoragePath());
    }

    public function testExpiresInStrictly()
    {
        $document = factory(Document::class)->states('validated')->create([
            'valid_until' => Carbon::today()->addDays(5),
        ]);

        $this->assertTrue(
            $document->expiresInStrictly(5),
            "The document should expire in exaclty 5 days"
        );
    }

    public function testExpiresIn()
    {
        $document = factory(Document::class)->states('validated')->create([
            'valid_until' => Carbon::today()->addDays(5),
        ]);

        $this->assertTrue(
            $document->expiresIn(6),
            "The document should expire in 6 days"
        );
    }
}
