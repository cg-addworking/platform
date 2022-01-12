<?php

namespace App\Jobs\Addworking\Contract\ContractPartyDocumentType;

use App\Models\Addworking\Contract\ContractPartyDocumentType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateContractPartyDocumentTypeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contractPartyDocumentType;
    protected $properties;

    public function __construct(ContractPartyDocumentType $type, array $properties)
    {
        $this->contractPartyDocumentType = $type;
        $this->properties = $properties;
    }

    public function handle()
    {
        DB::transaction(function () {
            $this->contractPartyDocumentType->fill($this->properties);

            if (isset($this->properties['document_type'])) {
                $this->contractPartyDocumentType
                    ->documentType()
                    ->associate($this->properties['document_type']);
            }

            $this->contractPartyDocumentType->save();
        });
    }
}
