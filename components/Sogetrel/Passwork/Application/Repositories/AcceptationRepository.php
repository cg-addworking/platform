<?php

namespace Components\Sogetrel\Passwork\Application\Repositories;

use App\Models\Sogetrel\User\Passwork as SogetrelPasswork;
use Components\Sogetrel\Passwork\Application\Models\Acceptation;
use Components\Sogetrel\Passwork\Domain\Exceptions\AcceptationCreationFailedException;
use Components\Sogetrel\Passwork\Domain\Interfaces\Entities\AcceptationEntityInterface;
use Components\Sogetrel\Passwork\Domain\Interfaces\Repositories\AcceptationRepositoryInterface;

class AcceptationRepository implements AcceptationRepositoryInterface
{
    public function make($data = []): AcceptationEntityInterface
    {
        return new Acceptation($data);
    }

    public function save(AcceptationEntityInterface $acceptation): AcceptationEntityInterface
    {
        try {
            $acceptation->save();
        } catch (AcceptationCreationFailedException $exception) {
            throw $exception;
        }

        $acceptation->refresh();

        return $acceptation;
    }

    public function list(
        ?array $filter = null,
        ?string $search = null,
        ?string $page,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        return Acceptation::query()
            ->when($search ?? null, function ($query, $search) use ($operator, $field_name) {
                return $query->search($search, $operator, $field_name);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate($page ?: 25);
    }

    public function getSearchableAttributes()
    {
        return [
            AcceptationEntityInterface::SEARCHABLE_ATTRIBUTE_ENTERPRISE_NAME =>
                __('sogetrel_passwork::acceptation._filters.enterprise_name'),
        ];
    }
}
