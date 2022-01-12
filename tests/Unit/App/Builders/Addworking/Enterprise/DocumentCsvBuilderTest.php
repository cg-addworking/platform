<?php

namespace Tests\Unit\App\Builders\Addworking\Enterprise;

use App\Builders\Addworking\Enterprise\DocumentCsvBuilder;
use App\Models\Addworking\Enterprise\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentCsvBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function testNormalize()
    {
        $documents = factory(Document::class, 10)->create();
        $headers = ['UUID', 'Date de depot', "Date d'expiration", 'Prestataire', 'Type', 'Statut', 'Nature'];

        $builder = new DocumentCsvBuilder();
        $builder->addAll($documents);
        $handle = fopen($builder->getPathname(), 'r');

        $this->assertEquals($headers, fgetcsv($handle, 0, ';'));

        foreach ($documents as $document) {
            $this->assertEquals([
                $document->id,
                $document->created_at,
                $document->valid_until,
                $document->enterprise->name,
                remove_accents($document->documentType->display_name ?? ''),
                $document->status,
                $document->documentType->type,
            ], fgetcsv($handle, 0, ';'));
        }
    }
}
