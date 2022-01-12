<?php

namespace Components\Infrastructure\Export\Domain\Interfaces;

use App\Models\Addworking\User\User;

interface ExportRepositoryInterface
{
    public function list(User $user, ?array $filter = null, ?string $search = null);

    public function make($data = []): ExportEntityInterface;

    public function create(User $user, string $export_name): ExportEntityInterface;

    public function save(ExportEntityInterface $export);

    public function displayFilters(?array $filters = []): ?string;
}
