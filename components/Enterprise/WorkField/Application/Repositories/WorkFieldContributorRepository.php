<?php

namespace Components\Enterprise\WorkField\Application\Repositories;

use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Application\Models\WorkFieldContributor;
use Components\Enterprise\WorkField\Domain\Exceptions\WorkFieldCreationFailedException;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldContributorEntityInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldEntityInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\WorkFieldContributorRepositoryInterface;
use Illuminate\Support\Collection;

class WorkFieldContributorRepository implements WorkFieldContributorRepositoryInterface
{

    public function make($data = []): WorkFieldContributorEntityInterface
    {
        return new WorkFieldContributor($data);
    }

    public function save(
        WorkFieldContributorEntityInterface $work_field_contributor
    ): WorkFieldContributorEntityInterface {
        try {
            $work_field_contributor->save();
        } catch (WorkFieldCreationFailedException $exception) {
            throw $exception;
        }

        $work_field_contributor->refresh();

        return $work_field_contributor;
    }

    public function findByNumber(int $number): ?WorkFieldContributorEntityInterface
    {
        return WorkFieldContributor::where('number', $number)->first();
    }

    public function getAdminsOf(WorkFieldEntityInterface $work_field)
    {
        $admins = new Collection;

        $work_fiels_contributors = $work_field->workFieldContributors()->get();

        foreach ($work_fiels_contributors as $work_fiels_contributor) {
            if ($work_fiels_contributor->getIsAdmin()) {
                $admins->push($work_fiels_contributor->getContributor());
            }
        }

        return $admins;
    }

    public function isAdminOf($user, $work_field): bool
    {
        return $this->getAdminsOf($work_field)->pluck('id')->contains($user->getId());
    }

    public function getContributorsOf(WorkFieldEntityInterface $work_field)
    {
        $contributors = new Collection;

        $work_field_contributors = $work_field->workFieldContributors()->orderByDesc('created_at')->get();

        foreach ($work_field_contributors as $work_field_contributor) {
            $contributors->push($work_field_contributor->getContributor());
        }

        return $contributors;
    }

    public function isContributorOf($user, $work_field): bool
    {
        return $this->getContributorsOf($work_field)->pluck('id')->contains($user->getId());
    }

    public function delete(WorkFieldContributorEntityInterface $work_field_contributor)
    {
        $work_field_contributor = WorkFieldContributor::where('id', $work_field_contributor->id)->first();

        return $work_field_contributor->delete();
    }

    public function find($id): ?WorkFieldContributorEntityInterface
    {
        return WorkFieldContributor::where('id', $id)->first();
    }

    public function isContributor(User $user): bool
    {
        $is_contributor = WorkFieldContributor::whereHas('contributor', function ($query) use ($user) {
            return $query->where('id', $user->id);
        })->get();

        if (count($is_contributor)) {
            return true;
        }

        return false;
    }

    public function getWorkfieldContributorContractValidators(WorkFieldEntityInterface $work_field)
    {
        return WorkFieldContributor::whereHas('workField', function ($q) use ($work_field) {
            $q->where('id', $work_field->getId());
        })->where('is_contract_validator', true)
        ->get();
    }

    public function getAvailableRoles(bool $trans = false): array
    {
        $translation_base = "work_field::workfield.manage.roles";

        $roles  = [
            WorkFieldContributorEntityInterface::ROLE_BUYER => __("{$translation_base}.buyer"),
            WorkFieldContributorEntityInterface::ROLE_OPERATIONAL_MANAGER =>
                __("{$translation_base}.operational_manager"),
            WorkFieldContributorEntityInterface::ROLE_SUPERVISOR => __("{$translation_base}.supervisor"),
            WorkFieldContributorEntityInterface::ROLE_RESPONSIBLE_QHSE => __("{$translation_base}.responsible_qhse"),
            WorkFieldContributorEntityInterface::ROLE_AUDITOR => __("{$translation_base}.auditor"),
            WorkFieldContributorEntityInterface::ROLE_OBSERVER => __("{$translation_base}.observer"),
        ];

        return $trans ? $roles : array_keys($roles);
    }
}
