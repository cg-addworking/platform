<?php

namespace Components\Contract\Contract\Application\Commands;

use Carbon\Carbon;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Application\Models\Action;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SetContractState extends Command
{
    protected $signature = "contract:set-state";
    protected $description = 'Update contract state';
    protected $contractRepository;

    public function __construct(ContractRepository $contractRepository)
    {
        parent::__construct();

        $this->contractRepository = $contractRepository;
    }

    public function handle()
    {
        $this->updateContractToDueState();
        $this->updateContractToActiveState();
    }

    private function updateContractToDueState()
    {
        $active_contracts_request = Contract::where(function ($q) {
            $q->where('state', ContractEntityInterface::STATE_ACTIVE);
            $q->where('valid_from', '<', Carbon::now());
            $q->where('valid_until', '<', Carbon::now());
        })->whereDoesntHave('amendments');

        $active_contracts_count = $active_contracts_request->count();
        foreach ($active_contracts_request->get() as $contract) {
            ActionTrackingHelper::track(
                null,
                ActionEntityInterface::CONTRACT_EXPIRES,
                $contract,
                __('components.contract.contract.application.tracking.contract_expires')
            );
        }
        $active_contracts_request->update(['state' => ContractEntityInterface::STATE_DUE]);
        Log::info(
            $active_contracts_count .
            " contracts were set to " .
            ContractEntityInterface::STATE_DUE .
            " state."
        );
    }

    private function updateContractToActiveState()
    {
        $signed_contracts_request = Contract::where(function ($q) {
            $q->where('state', ContractEntityInterface::STATE_SIGNED);
            $q->where('valid_from', '<', Carbon::now());
            $q->where(function ($q) {
                $q->where('valid_until', '>', Carbon::now());
                $q->orWhere('valid_until', null);
            });
        })->whereDoesntHave('amendments');
        $signed_contracts_count = $signed_contracts_request->count();
        foreach ($signed_contracts_request->get() as $contract) {
            ActionTrackingHelper::track(
                null,
                ActionEntityInterface::CONTRACT_IS_ACTIVE,
                $contract,
                __('components.contract.contract.application.tracking.contract_is_active')
            );
        }
        $signed_contracts_request->update(['state' => ContractEntityInterface::STATE_ACTIVE]);
        Log::info(
            $signed_contracts_count .
            " contracts were set to " .
            ContractEntityInterface::STATE_ACTIVE .
            " state."
        );
    }
}
