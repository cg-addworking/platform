<?php

namespace Components\Contract\Model\Application\Repositories;

use Components\Contract\Model\Application\Models\ContractModelParty;
use Components\Contract\Model\Domain\Exceptions\ContractModelPartyCreationFailedException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelPartyRepositoryInterface;

class ContractModelPartyRepository implements ContractModelPartyRepositoryInterface
{
    private $contractModelRepository;

    public function __construct()
    {
        $this->contractModelRepository = new ContractModelRepository();
    }

    public function make($data = []): ContractModelPartyEntityInterface
    {
        return new ContractModelParty($data);
    }

    public function save(ContractModelPartyEntityInterface $contract_model_party)
    {
        try {
            $contract_model_party->save();
        } catch (ContractModelPartyCreationFailedException $exception) {
            throw $exception;
        }

        $contract_model_party->refresh();

        return $contract_model_party;
    }

    public function find(string $id): ContractModelPartyEntityInterface
    {
        return ContractModelParty::where('id', $id)->first();
    }

    public function delete(ContractModelPartyEntityInterface $contract_model_party): bool
    {
        return $contract_model_party->delete();
    }

    public function isDeletable(ContractModelPartyEntityInterface $contract_model_party): bool
    {
        $contract_model = $contract_model_party->getContractModel();

        if ($this->contractModelRepository->isPublished($contract_model)) {
            return false;
        }

        if ($this->contractModelRepository->isArchived($contract_model)) {
            return false;
        }

        return count($contract_model_party->getContractModel()->getParties()) > 2;
    }

    public function findByOrder(
        ContractModelEntityInterface $contract_model,
        int $order
    ): ?ContractModelPartyEntityInterface {
        return ContractModelParty::where('order', $order)
            ->whereHas('contractModel', function ($query) use ($contract_model) {
                $query->where('id', $contract_model->getId());
            })->first();
    }

    public function findByNumber(int $number): ?ContractModelPartyEntityInterface
    {
        return ContractModelParty::where('number', $number)->first();
    }

    public function calculateSignaturePosition(int $order): string
    {
        switch ($order) {
            case 1:
                $position = "32,70,130,141";
                break;
            case 2:
                $position = "172,70,270,141";
                break;
            case 3:
                $position = "302,70,410,141";
                break;
            case 4:
                $position = "432,70,560,141";
                break;
        }

        return $position;
    }
}
