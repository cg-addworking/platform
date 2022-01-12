<?php

namespace App\Jobs\Addworking\Contract\ContractPartyDocumentType;

use App\Models\Addworking\Contract\ContractPartyDocumentType;
use App\Models\Addworking\Enterprise\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AttachExistingDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $contractPartyDocumentType;
    public $contractDocument;
    public $document;

    public function __construct(ContractPartyDocumentType $type, Document $doc)
    {
        $this->contractPartyDocumentType = $type;
        $this->document = $doc;
    }

    public function handle()
    {
        $this->contractDocument = $this->contractPartyDocumentType->contractParty->contract
            ->contractDocuments()
            ->make();

        $this->contractDocument
            ->contractParty()
            ->associate($this->contractPartyDocumentType->contractParty);

        $this->contractDocument
            ->document()
            ->associate($this->document);

        return $this->contractDocument->save();
    }
}
