<?php

namespace App\Events\Addworking\Enterprise\Document;

use App\Models\Addworking\Enterprise\Document;
use Illuminate\Queue\SerializesModels;

class DocumentCreated
{
    use SerializesModels;

    public $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }
}
