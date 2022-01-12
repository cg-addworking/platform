<?php

namespace Components\Enterprise\Enterprise\Application\Repositories;

use Components\Enterprise\Enterprise\Application\Models\Company;
use Components\Enterprise\Enterprise\Domain\Interfaces\CompanyRepositoryInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyEntityInterface;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function findByShortId(string $short_id): ?CompanyEntityInterface
    {
        return Company::where('short_id', $short_id)->first();
    }

    public function listAsSupport(
        ?array $filter = null,
        ?string $search = null,
        ?string $page,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        return Company::query()
            ->when($search ?? null, function ($query, $search) use ($operator, $field_name) {
                return $query->search($search, $operator, $field_name);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate($page ?: 25);
    }

    public function getSearchableAttributes()
    {
        return [
            CompanyEntityInterface::SEARCHABLE_ATTRIBUTE_NAME =>
                'company::company.filters.name',
            CompanyEntityInterface::SEARCHABLE_ATTRIBUTE_IDENTIFICATION_NUMBER =>
                'company::company.filters.identification_number',
        ];
    }

    public function getShareCapital(Company $company): string
    {
        $share_capital = $company->getCompanyShareCapital()->first();

        if ($share_capital) {
            return $share_capital->getAmount() . " " .strtoupper($share_capital->getCurency()->getAcronym());
        }

        return 'n/a';
    }
}
