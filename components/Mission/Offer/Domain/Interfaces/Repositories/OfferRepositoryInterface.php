<?php

namespace Components\Mission\Offer\Domain\Interfaces\Repositories;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\User\User;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;

interface OfferRepositoryInterface
{
    public function make(): OfferEntityInterface;
    public function save(OfferEntityInterface $offer);
    public function findByNumber($number): ?OfferEntityInterface;
    public function hasAcceptedResponses(OfferEntityInterface $offer): bool;
    public function getAvailableStatuses(bool $trans = false): array;
    public function list(
        User $user,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    );
    public function getSearchableAttributes(): array;
    public function createFiles($files, OfferEntityInterface $offer);
    public function userEnterpriseIsOfferOwner(User $user, OfferEntityInterface $offer): bool;
    public function delete(OfferEntityInterface $offer);
    public function deleteFile(File $file);
}
