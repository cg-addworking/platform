<?php

namespace Components\Contract\Contract\Application\Jobs;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\UseCases\DefineContractVariableValue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

/**
 * Deprecated @todo remove it
 */
class DefineContractVariableValueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contract;
    protected $contractRepository;
    protected $contractVariableRepository;
    protected $user;
    protected $input_variables;

    public function __construct(
        User $user,
        ContractEntityInterface $contract,
        array $input_variables
    ) {
        $this->contractRepository         = new ContractRepository;
        $this->contractVariableRepository = new ContractVariableRepository;
        $this->user                       = $user;
        $this->contract                   = $contract;
        $this->input_variables            = $input_variables;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->contractRepository->canBeRegenerated($this->contract)) {
            $this->contract->setState(ContractEntityInterface::STATUS_GENERATING);
            $this->contractRepository->save($this->contract);
        }

        DB::transaction(function () {
            $variables = $this->contractVariableRepository->findMany(
                array_keys($this->input_variables),
                ['contractModelVariable']
            );
            App::make(DefineContractVariableValue::class)
                ->handle($this->user, $variables, $this->input_variables);
        });

        if ($this->contractRepository->canBeRegenerated($this->contract)) {
            $this->contract->setState(ContractEntityInterface::STATUS_GENERATING);
            $this->contractRepository->save($this->contract);
            GenerateContractPartsJob::dispatch($this->user, $this->contract);
        }
    }
}
