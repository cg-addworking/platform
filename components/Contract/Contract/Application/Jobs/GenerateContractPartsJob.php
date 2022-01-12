<?php

namespace Components\Contract\Contract\Application\Jobs;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\UseCases\CreateContractPartFromModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class GenerateContractPartsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contract;
    protected $contractPartRepository;
    protected $contractRepository;
    protected $user;

    public function __construct(
        User $user,
        ContractEntityInterface $contract
    ) {
        $this->user = $user;
        $this->contract = $contract;
        $this->contractPartRepository = new ContractPartRepository;
        $this->contractRepository = new ContractRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->contractRepository->hasYousignProcedureId($this->contract)
            || ! $this->contractRepository->hasContractModel($this->contract)) {
            return;
        }

        $this->deletePartsWithModel($this->contract);
        
        try {
            foreach ($this->contract->getContractModel()->getParts() as $contract_model_part) {
                App::make(CreateContractPartFromModel::class)
                    ->handle(
                        $this->user,
                        $this->contract,
                        $contract_model_part
                    );

                unset($contract_model_part);
                gc_collect_cycles();
            }
        } catch (\Exception $e) {
            Log::error($e);
            $this->deletePartsWithModel($this->contract);
        }

        App::make(ContractStateRepository::class)->updateContractState($this->contract);

        if ($this->contract->getState() == ContractEntityInterface::STATE_IN_PREPARATION
            && $this->contract->getContractModel()->getShouldVendorsFillTheirVariables()
        ) {
            App::make(ContractRepositoryInterface::class)
                ->sendNotificationContractNeedsVariablesValues($this->contract);
        }
    }

    private function deletePartsWithModel(ContractEntityInterface $contract)
    {
        $contractPartsWithModel = $this->contractPartRepository->getPartsWithModel($contract);
        if (count($contractPartsWithModel)) {
            $this->contractPartRepository->destroy($contractPartsWithModel->pluck('id'));
        }

        unset($contractPartsWithModel);
    }
}
