<?php

namespace Components\Contract\Model\Application\Repositories;

use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Models\ContractModelParty;
use Components\Contract\Model\Application\Models\ContractModelVariable;
use Components\Contract\Model\Domain\Exceptions\ContractModelCreationFailedException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;

class ContractModelRepository implements ContractModelRepositoryInterface
{
    public function find(string $id): ?ContractModelEntityInterface
    {
        return ContractModel::where('id', $id)->first();
    }

    public function make($data = []): ContractModel
    {
        return new ContractModel($data);
    }

    public function save(ContractModelEntityInterface $contract_model)
    {
        try {
            $contract_model->save();
        } catch (ContractModelCreationFailedException $exception) {
            throw $exception;
        }

        $contract_model->refresh();

        return $contract_model;
    }

    public function replicate(ContractModelEntityInterface $model)
    {
        $copy = $model->replicate();
        $copy->save();

        $allParts = [];
        foreach ($model->parts()->get() as $part) {
            $newPart = $part->replicate();
            $newPart->contractModel()->associate($copy)->save();
            $allParts[$part->getId()] = $newPart;
        }
        
        foreach ($model->parties()->get() as $party) {
            $newParty = $party->replicate();
            $newParty->contractModel()->associate($copy)->save();
            foreach ($party->partyDocumentTypes()->get() as $document) {
                $newDocument = $document->replicate();
                $newDocument->contractModelParty()->associate($newParty)->save();
            }

            foreach ($party->getVariables() as $variable) {
                $newVariable = $variable->replicate();
                $newVariable->contractModel()->associate($copy);
                $newVariable->contractModelParty()->associate($newParty);
                foreach ($allParts as $id => $part) {
                    if ($variable->getContractModelPart()->getId() === $id) {
                        $newVariable->contractModelPart()->associate($part)->save();
                    }
                }
            }
        }
    
        return $copy;
    }

    public function isPublished($contract_model): bool
    {
        return ! is_null($contract_model->published_at);
    }

    public function isArchived($contract_model): bool
    {
        return ! is_null($contract_model->archived_at);
    }

    public function isDraft(ContractModelEntityInterface $contract_model): bool
    {
        return (! $this->isPublished($contract_model) && ! $this->isArchived($contract_model));
    }

    public function hasChildVersion(ContractModelEntityInterface $contract_model): bool
    {
        return is_null(ContractModel::where('versionning_from_id', $contract_model->getId())->first());
    }

    public function findByNumber(string $number): ?ContractModelEntityInterface
    {
        return ContractModel::where('number', $number)->first();
    }

    public function list(
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        return ContractModel::query()
        ->whereNull('archived_at')
        ->when($filter['archived_contract_model'] ?? null, function ($query, $filter) {
            return ContractModel::query()->whereNotNull('archived_at');
        })
        ->when($filter['statuses'] ?? null, function ($query, $statuses) {
            return $query->filterStatus($statuses);
        })
        ->when($filter['enterprises'] ?? null, function ($query, $enterprises) {
            return $query->filterEnterprise($enterprises);
        })
        ->when($search ?? null, function ($query, $search) use ($operator, $field_name) {
            return $query->search($search, $operator, $field_name);
        })
        ->latest()
        ->paginate($page ?? 25);
    }

    public function delete(ContractModelEntityInterface $contract_model): bool
    {
        return $contract_model->delete();
    }

    public function isDeleted(string $number): bool
    {
        return ! is_null(ContractModel::withTrashed()
            ->where('number', $number)
            ->first()
            ->getDeletedAt());
    }

    public function getEnterpriseAndChildren(ContractModelEntityInterface $contract_model)
    {
        return $contract_model->getEnterprise()->children()->get()
            ->push($contract_model->getEnterprise());
    }

    public function checkIfModelAttachedToContract(ContractModelEntityInterface $contract_model)
    {
        return $contract_model->getContracts()->count();
    }

    public function getAvailableStatuses(bool $trans = false): array
    {
        $translation_base = "components.contract.model.application.views.contract_model._state";

        $statuses  = [
            ContractModelEntityInterface::STATUS_DRAFT => __("{$translation_base}.Draft"),
            ContractModelEntityInterface::STATUS_PUBLISHED => __("{$translation_base}.Published"),
            ContractModelEntityInterface::STATUS_ARCHIVED => __("{$translation_base}.Archived"),
        ];

        return $trans ? $statuses : array_keys($statuses);
    }

    public function getSearchableAttributes(): array
    {
        return [
            ContractModelEntityInterface::SEARCHABLE_ATTRIBUTE_DISPLAY_NAME =>
                'components.contract.model.application.views.contract_model._table_head.display_name'
        ];
    }

    public function getAllPublishedContractModels()
    {
        return ContractModel::whereNotNull('published_at')->get();
    }
}
