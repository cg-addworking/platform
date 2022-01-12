<?php

namespace Components\Enterprise\WorkField\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\CustomerRepository;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Carbon\Carbon;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Enterprise\WorkField\Application\Models\WorkFieldContributor;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Components\Enterprise\WorkField\Domain\Exceptions\WorkFieldCreationFailedException;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldEntityInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\WorkFieldRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class WorkFieldRepository implements WorkFieldRepositoryInterface
{
    public function make($data = []): WorkFieldEntityInterface
    {
        return new WorkField($data);
    }

    public function save(WorkFieldEntityInterface $work_field): WorkFieldEntityInterface
    {
        try {
            $work_field->save();
        } catch (WorkFieldCreationFailedException $exception) {
            throw $exception;
        }

        $work_field->refresh();

        return $work_field;
    }

    public function findByNumber(int $number, ?bool $trashed = null): ?WorkFieldEntityInterface
    {
        if ($trashed) {
            return WorkField::withTrashed()->where('number', $number)->first();
        }
        return WorkField::where('number', $number)->first();
    }

    public function getCustomersWithConstructionSector()
    {
        return App::make(CustomerRepository::class)
            ->getAvailableCustomers()
            ->filter(function ($enterprise) {
                return App::make(SectorRepository::class)->belongsToConstructionSector($enterprise);
            });
    }

    public function isCreatorOf(User $user, WorkFieldEntityInterface $work_field)
    {
        // temporary for the api (workfield creation by api)
        if (is_null($work_field->getCreatedBy())) {
            return false;
        }

        if ($user->id === $work_field->getCreatedBy()->id) {
            return true;
        }

        return false;
    }

    public function getOwnerEnterprisesWithConstructionSector(User $user)
    {
        $enterprisesCollection = new Collection;
        foreach ($user->enterprises as $enterprise) {
            if ($user->hasRoleFor($enterprise, User::ROLE_WORKFIELD_CREATOR)) {
                $enterprisesCollection->push($enterprise);
            }
        }
        return $enterprisesCollection;
    }

    public function hasAccessToWorkField(User $user, ?WorkFieldEntityInterface $work_field): bool
    {
        if ($this->isCreatorOf($user, $work_field) ||
            App::make(WorkFieldContributorRepository::class)->isContributorOf($user, $work_field)) {
            return true;
        }

        return false;
    }

    public function find($work_field_id)
    {
        return WorkField::where('id', $work_field_id)->first();
    }

    public function delete(WorkFieldEntityInterface $work_field): bool
    {
        $work_field->deletedBy()->associate(
            App::make(UserRepository::class)->connectedUser()
        )->save();

        return $work_field->delete();
    }

    public function isDeleted(string $number): bool
    {
        return is_null(WorkField::where('number', $number)->first());
    }

    public function list(
        User $user,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        $is_admin = $user->hasRoleFor($user->enterprise, User::ROLE_ADMIN);

        return WorkField::query()
            ->with('owner')
            ->where(function ($query) use ($user, $is_admin) {
                if ($is_admin) {
                    return $query->whereHas('owner', function ($query) use ($user) {
                        return $query->where('id', $user->enterprise->id);
                    });
                } else {
                    return $query
                        ->whereHas('createdBy', function ($query) use ($user) {
                            return $query->where('id', $user->id);
                        })
                        ->orWhereHas('workFieldContributors', function ($query) use ($user) {
                            return $query->whereHas('contributor', function ($query) use ($user) {
                                return $query->where('id', $user->id);
                            });
                        });
                }
            })
            ->when($search ?? null, function ($query, $search) use ($operator, $field_name) {
                return $query->search($search, $operator, $field_name);
            })
            ->latest()
            ->paginate($page ?? 25);
    }

    public function archive(WorkFieldEntityInterface $work_field)
    {
        $work_field->setArchivedAt();

        $work_field->setArchivedBy(
            App::make(UserRepository::class)->connectedUser()
        );

        return $work_field->save();
    }

    public function getSearchableAttributes(): array
    {
        return [
            WorkFieldEntityInterface::SEARCHABLE_ATTRIBUTE_NAME =>
                'work_field::workfield._table_head.workfield_name',
            WorkFieldEntityInterface::SEARCHABLE_ATTRIBUTE_EXTERNAL_IDENTIFIER =>
                'work_field::workfield._table_head.external_id',
        ];
    }

    public function getMaxOrderofValidatorContributor(WorkFieldEntityInterface $work_field)
    {
        return WorkFieldContributor::where('work_field_id', $work_field->getId())
            ->where('is_contract_validator', true)
            ->max('contract_validation_order');
    }
}
