<?php

namespace Components\Contract\Contract\Application\Jobs;

use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateContractVariableJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contract;
    protected $contractRepository;
    protected $contractVariableRepository;
    protected $user;
    protected $input_variables;

    public function __construct(
        ContractEntityInterface $contract
    ) {
        $this->contractRepository         = new ContractRepository;
        $this->contractVariableRepository = new ContractVariableRepository;
        $this->contract                   = $contract;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->contractRepository->getSignatoryParties($this->contract) as $contract_party) {
            $this->contractVariableRepository->createContractVariables(
                $this->contract,
                $contract_party->getContractModelParty(),
                $contract_party
            );

            unset($contract_party);
        }
    }
}
