<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Annex;
use Components\Contract\Contract\Domain\Interfaces\Entities\AnnexEntityInterface;

interface AnnexRepositoryInterface
{
    public function make($data = []): AnnexEntityInterface;
    public function save(AnnexEntityInterface $annex);
    public function createFile($content);
    public function findByNumber(string $number): ?AnnexEntityInterface;
    public function delete(AnnexEntityInterface $annex);
    public function isDeleted(int $number): bool;
    public function listAsSupport(
        ?User $user,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    );
    public function list(Enterprise $enterprise);
    public function findById(string $annex_number): ?Annex;
}
