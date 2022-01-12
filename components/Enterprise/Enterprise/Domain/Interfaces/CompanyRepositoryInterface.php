<?php

namespace Components\Enterprise\Enterprise\Domain\Interfaces;

use Components\Enterprise\Enterprise\Application\Models\Company;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyEntityInterface;

interface CompanyRepositoryInterface
{
    public function findByShortId(string $short_id): ?CompanyEntityInterface;
    public function listAsSupport(
        ?array $filter = null,
        ?string $search = null,
        ?string $page,
        ?string $operator = null,
        ?string $field_name = null
    );
    public function getSearchableAttributes();
    public function getShareCapital(Company $company): string;
}
