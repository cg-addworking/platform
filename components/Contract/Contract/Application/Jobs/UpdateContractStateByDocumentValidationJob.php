<?php

namespace Components\Contract\Contract\Application\Jobs;

use App\Models\Addworking\Enterprise\Document;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class UpdateContractStateByDocumentValidationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $document;
    protected $contractStateRepository;

    public function __construct(Document $document)
    {
        $this->document = $document;
        $this->contractStateRepository = App::make(ContractStateRepository::class);
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $contracts = Contract::whereHas('parties', function ($query) {
            $query->whereHas('enterprise', function ($query) {
                $query->where('id', $this->document->enterprise->id);
            });
        })->whereHas('contractModel', function ($query) {
            $query->whereHas('parties', function ($query) {
                $query->doesntHave('partyDocumentTypes')->orWhereHas('partyDocumentTypes', function ($query) {
                    $query->doesntHave('documentType')->orWhereHas('documentType', function ($query) {
                        $query->where('id', $this->document->documentType->id);
                    });
                });
            });
        })->get();

        foreach ($contracts as $contract) {
            $this->contractStateRepository->updateContractState($contract);
        }
    }
}
