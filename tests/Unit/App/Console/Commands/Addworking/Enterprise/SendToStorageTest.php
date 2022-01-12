<?php

namespace Tests\Unit\App\Console\Commands\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SendToStorageTest extends TestCase
{
    use RefreshDatabase;

    public function testHandle()
    {
        Storage::fake('fake_documents_s3');

        // do NOT send documents automatically, we'll send the
        // docs manually through the command
        Config::set('documents.storage.enabled', false);
        Config::set('documents.storage.disk', 'fake_documents_s3');

        // test command for one doc
        $doc = factory(Document::class)->create();

        Artisan::call('document:send-to-storage', ['document' => $doc->id, '--disk' => "fake_documents_s3"]);

        Storage::disk('fake_documents_s3')->assertExists($doc->getStoragePath());

        // test command for 5 docs
        $docs = factory(Document::class, 5)->create();

        Artisan::call('document:send-to-storage', ['--disk' => "fake_documents_s3"]);

        foreach ($docs as $doc) {
            Storage::disk('fake_documents_s3')->assertExists($doc->getStoragePath());
        }
    }

    public function testHandleWithSoftDeletedDocuments()
    {
        Storage::fake('fake_documents_s3');

        // do NOT send documents automatically, we'll send the
        // docs manually through the command
        Config::set('documents.storage.enabled', false);
        Config::set('documents.storage.disk', 'fake_documents_s3');

        // test command for 5 docs
        $docs = factory(Document::class, 5)->create();

        $docs->each(function ($doc) {
            $doc->delete();
        });

        Artisan::call('document:send-to-storage', ['--disk' => "fake_documents_s3"]);

        foreach ($docs as $doc) {
            Storage::disk('fake_documents_s3')->assertExists($doc->getStoragePath());
        }
    }
}
