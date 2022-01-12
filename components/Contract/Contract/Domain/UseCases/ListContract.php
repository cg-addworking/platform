<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\SearchFieldIsNotAllowedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ListContract implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $contractRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ContractRepositoryInterface $contractRepository
    ) {
        $this->userRepository     = $userRepository;
        $this->contractRepository = $contractRepository;
    }

    public function handle(
        ?User $auth_user,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        $this->checkUser($auth_user);

        return $this->contractRepository->list($auth_user, $filter, $search, $page, $operator, $field_name);
    }

    public function checkSearch(?string $field_name)
    {
        if (isset($field_name)
            && !array_key_exists(
                $field_name,
                $this->contractRepository->getSearchableAttributes()
            )
        ) {
            throw new SearchFieldIsNotAllowedException;
        }
    }

    public function checkUser(?User $auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException;
        }
    }
}
