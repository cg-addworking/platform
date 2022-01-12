<?php

namespace App\Jobs\Addworking\Contract\ContractPartyDocumentType;

use App\Models\Addworking\Contract\ContractParty;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CreateContractPartyDocumentTypeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $properties;
    public $contractParty;
    public $contractPartyDocumentType;

    public function __construct(ContractParty $party, array $properties)
    {
        $this->contractParty = $party;
        $this->properties = $properties;
    }

    public function handle()
    {
        DB::transaction(function () {
            $this->contractPartyDocumentType = $this->contractParty
                ->contractPartyDocumentTypes()
                ->make($this->properties);

            if (isset($this->properties['document_type'])) {
                $this->contractPartyDocumentType
                    ->documentType()
                    ->associate($this->properties['document_type']);
            }

            $this->contractPartyDocumentType->save();
        });
    }
}
