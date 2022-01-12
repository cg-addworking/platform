<?php

namespace Components\Contract\Contract\Application\Jobs;

use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\UseCases\CreateContractPart;
use Components\Contract\Contract\Domain\UseCases\EditContractPart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;

class UploadSignedContractJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contractRepository;
    protected $auth_user;
    protected $contract;
    protected $inputs;
    protected $file;

    public function __construct(
        ContractRepository $contractRepository,
        User $auth_user,
        ContractEntityInterface $contract,
        array $inputs,
        $file
    ) {
        $this->contractRepository = $contractRepository;
        $this->auth_user = $auth_user;
        $this->contract = $contract;
        $this->inputs = $inputs;
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->contractRepository->getContractParts($this->contract) as $part) {
            App::make(EditContractPart::class)
                ->handle(
                    $this->auth_user,
                    $part,
                    ['is_hidden' => true]
                );
        }

        App::make(CreateContractPart::class)->handle(
            $this->auth_user,
            $this->contract,
            $this->inputs['contract_part'],
            $this->file
        );

        foreach ($this->contractRepository->getSignatoryParties($this->contract) as $contract_party) {
            $contract_party->setSignedAt($this->inputs['contract_party']['signed_at'][$contract_party->getId()]);
            App::make(ContractPartyRepository::class)->save($contract_party);
        }

        $this->contract->setSentToSignatureAt(Carbon::now());
        $this->contractRepository->save($this->contract);
    }
}
