<?php

namespace App\Jobs\Addworking\Contract\ContractPartyDocumentType;

use App\Models\Addworking\Contract\ContractPartyDocumentType;
use App\Support\Facades\Repository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DetachDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contractPartyDocumentType;

    public function __construct(ContractPartyDocumentType $type)
    {
        $this->contractPartyDocumentType = $type;
    }

    public function handle()
    {
        return Repository::contractPartyDocumentType()
            ->getContractDocument($this->contractPartyDocumentType)
            ->delete();
    }
}
