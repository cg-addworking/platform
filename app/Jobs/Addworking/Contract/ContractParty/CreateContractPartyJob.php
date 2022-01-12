<?php

namespace App\Jobs\Addworking\Contract\ContractParty;

use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractParty;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Contract\ContractPartyRepository;
use App\Repositories\Addworking\Contract\ContractRepository;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use App\Support\Facades\Repository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class CreateContractPartyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $contract;
    public $enterprise;
    public $properties;
    public $contractParty;

    public function __construct(Contract $contract, Enterprise $enterprise, array $properties)
    {
        $this->contract = $contract;
        $this->enterprise = $enterprise;
        $this->properties = $properties;
    }

    public function handle()
    {
        $this->contractParty = Repository::contractParty()
            ->make($this->properties += [
                'order' => $this->contract->contractParties()->count() +1,
            ]);

        return $this->contractParty
            ->contract()->associate($this->contract)
            ->enterprise()->associate($this->enterprise)
            ->save();
    }
}
