<?php

namespace Components\Contract\Model\Application\Repositories;

use App\Models\Addworking\Common\File;
use Components\Contract\Model\Application\Models\ContractModelDocumentType;
use Components\Contract\Model\Domain\Exceptions\ContractModelDocumentTypeCreationFailedException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelDocumentTypeEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelDocumentTypeRepositoryInterface;

class ContractModelDocumentTypeRepository implements ContractModelDocumentTypeRepositoryInterface
{
    public function make(array $data = []): ContractModelDocumentType
    {
        return new ContractModelDocumentType($data);
    }

    public function save(ContractModelDocumentTypeEntityInterface $contract_model_document_type)
    {
        try {
            $contract_model_document_type->save();
        } catch (ContractModelDocumentTypeCreationFailedException $exception) {
            throw $exception;
        }

        $contract_model_document_type->refresh();

        return $contract_model_document_type;
    }

    public function getFromContractModelParty(ContractModelPartyEntityInterface $contract_model_party)
    {
        return ContractModelDocumentType::whereHas('contractModelParty', function ($query) use ($contract_model_party) {
            return $query->where('id', $contract_model_party->getId());
        })->has('documentType')->get();
    }

    public function findByNumber(int $number): ?ContractModelDocumentType
    {
        return ContractModelDocumentType::where('number', $number)->first();
    }

    public function delete(ContractModelDocumentTypeEntityInterface $contract_model_document_type): bool
    {
        return $contract_model_document_type->delete();
    }

    public function list(?array $filter, ?string $search, ContractModelPartyEntityInterface $contract_model_party)
    {
        return ContractModelDocumentType::query()->with(['documentType', 'contractModelParty', 'validatedBy'])
            ->whereHas('contractModelParty', function ($query) use ($contract_model_party) {
                return $query->where('id', $contract_model_party->getId());
            })->latest()
            ->paginate(25);
    }

    public function createFile($content)
    {
        return File::from($content)
            ->fill(['mime_type' => "application/pdf"])
            ->name("/". uniqid() ."-%ts%.pdf")
            ->saveAndGet();
    }
}
