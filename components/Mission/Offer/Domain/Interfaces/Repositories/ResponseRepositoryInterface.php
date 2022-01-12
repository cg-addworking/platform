<?php

namespace Components\Mission\Offer\Domain\Interfaces\Repositories;

use App\Models\Addworking\User\User;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Components\Mission\Offer\Domain\Interfaces\Entities\ResponseEntityInterface;

interface ResponseRepositoryInterface
{
    public function make(): ResponseEntityInterface;
    public function save(ResponseEntityInterface $response);
    public function createFile($content);
    public function list(
        User $user,
        OfferEntityInterface $offer,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    );
    public function findByNumber(string $number): ?ResponseEntityInterface;
    public function userEnterpriseIsResponseOwner(User $user, ResponseEntityInterface $response): bool;
}
