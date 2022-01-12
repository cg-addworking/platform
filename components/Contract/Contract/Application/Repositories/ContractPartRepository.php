<?php

namespace Components\Contract\Contract\Application\Repositories;

use App\Models\Addworking\Common\File;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractPart;
use Components\Contract\Contract\Domain\Exceptions\ContractPartCreationFailedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;
use Illuminate\Support\Facades\App;

class ContractPartRepository implements ContractPartRepositoryInterface
{
    public function make($data = []): ContractPartEntityInterface
    {
        return new ContractPart($data);
    }

    public function save(ContractPartEntityInterface $contract_part)
    {
        try {
            $contract_part->save();
        } catch (ContractPartCreationFailedException $exception) {
            throw $exception;
        }

        $contract_part->refresh();

        return $contract_part;
    }

    public function createFile($content)
    {
        $file = File::from($content)
            ->fill(['mime_type' => "application/pdf"])
            ->name("/part_%uniq%.pdf")
            ->saveAndGet();

        unset($content);
        return $file;
    }

    public function getContractPartsFrom(
        ContractModelPartEntityInterface $contract_model_part,
        ContractEntityInterface $contract
    ) {
        return $contract_model_part->contractParts()->whereHas('contract', function ($query) use ($contract) {
            return $query->where('contract_id', $contract->getId());
        });
    }

    public function destroy($collection): bool
    {
        return ContractPart::destroy($collection) == count($collection);
    }

    public function findByNumber(string $number)
    {
        return ContractPart::where('number', $number)->first();
    }

    public function delete(ContractPartEntityInterface $contract_part): bool
    {
        return $contract_part->delete();
    }

    public function hasContractModelPart(ContractPartEntityInterface $contract_part): bool
    {
        return !is_null($contract_part->getContractModelPart());
    }

    public function getPartsWithModel(ContractEntityInterface $contract)
    {
        return ContractPart::has('contractModelPart')->whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->getId());
        })->get();
    }

    public function findByOrder(ContractEntityInterface $contract, int $order): ?ContractPartEntityInterface
    {
        return App::make(ContractRepository::class)->getContractParts($contract)
            ->filter(function ($part) use ($order) {
                return $part->getorder() == $order;
            })
            ->first();
    }

    public function isOrderedFirst(ContractPartEntityInterface $contract_part, string $direction): bool
    {
        return $direction == ContractPartEntityInterface::ORDER_UP && $contract_part->getOrder() == 1;
    }

    public function isOrderedLast(ContractPartEntityInterface $contract_part, string $direction): bool
    {
        $visible_contract_parts_count = App::make(ContractRepository::class)
            ->getContractParts($contract_part->getContract(), true)
            ->count();

        return $direction == ContractPartEntityInterface::ORDER_DOWN &&
            $contract_part->getOrder() == $visible_contract_parts_count;
    }

    public function createContractPartFromInput(
        ContractEntityInterface $contract,
        array $inputs,
        $file
    ): ContractPartEntityInterface {
        $file = $this->createFile($file);

        $contract_part = $this->make();
        $contract_part->setContract($contract);
        $contract_part->setFile($file);
        $contract_part->setDisplayName($inputs['display_name']);
        $contract_part->setName($inputs['display_name']);
        $contract_part->setNumber();
        $contract_part->setIsSigned(true);
        $contract_part->setSignaturePage($inputs['signature_page']);
        $contract_part->setSignatureMention($inputs['signature_mention']);

        return $this->save($contract_part);
    }

    public function find(string $id): ?ContractPartEntityInterface
    {
        return ContractPart::where('id', $id)->first();
    }
}
