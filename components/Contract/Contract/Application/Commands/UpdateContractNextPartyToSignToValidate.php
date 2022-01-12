<?php

namespace Components\Contract\Contract\Application\Commands;

use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateContractNextPartyToSignToValidate extends Command
{
    protected $signature = 'contract:update-next-party-to-sign-to-validate';

    protected $description = 'Updates next party to sign and next party to validate';

    protected $contractRepository;
    protected $contractPartyRepository;

    public function __construct(
        ContractPartyRepository $contractPartyRepository,
        ContractRepository $contractRepository
    ) {
        parent::__construct();

        $this->contractPartyRepository = $contractPartyRepository;
        $this->contractRepository = $contractRepository;
    }

    public function handle()
    {
        $contracts = Contract::whereIn(
            'state',
            [ContractEntityInterface::STATE_TO_VALIDATE, ContractEntityInterface::STATE_TO_SIGN]
        )->get();

        Log::info('Starting with ' . $contracts->count() . ' contracts found.');
        $count_updated_validator = 0;
        $count_updated_signatory = 0;
        $count_update_errors     = 0;
        foreach ($contracts as $contract) {
            /* @var Contract $contract */
            try {
                $update_contract = false;
                $next_party_to_validate = $this->contractPartyRepository->getNextPartyThatShouldValidate($contract);
                $contract_next_party_to_validate = $contract->getNextPartyToValidate();
                if (isset($next_party_to_validate)
                    && (
                        is_null($contract_next_party_to_validate) || (
                            !is_null($contract_next_party_to_validate)
                            && $next_party_to_validate->getId() !== $contract->getNextPartyToValidate()->getId()
                        )
                    )
                ) {
                    $contract->setNextPartyToValidate($next_party_to_validate);
                    $count_updated_validator++;
                    $update_contract = true;
                }

                $next_party_to_sign = $this->contractPartyRepository->getNextPartyThatShouldSign($contract);
                $contract_next_party_to_sign = $contract->getNextPartyToSign();
                if (isset($next_party_to_sign)
                    && (
                        is_null($contract_next_party_to_sign) || (
                            !is_null($contract_next_party_to_sign)
                            && $next_party_to_sign->getId() !== $contract->getNextPartyToSign()->getId()
                        )
                    )
                ) {
                    $contract->setNextPartyToSign($next_party_to_sign);
                    $count_updated_signatory++;
                    $update_contract = true;
                }

                if ($update_contract) {
                    $this->contractRepository->save($contract);
                }
            } catch (\Exception $e) {
                Log::error($e);
                $count_update_errors++;
            }
        }
        Log::info('Update finished:' . $count_updated_signatory . ' next party to sign updated, '
            . $count_updated_validator . ' next party to validated updated and '
            . $count_update_errors . ' errors.');
    }
}
