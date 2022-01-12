<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\AnnexIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Contract\Domain\Interfaces\Entities\AnnexEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\AnnexRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;

class DeleteAnnex
{
    private $annexRepository;
    private $userRepository;

    public function __construct(
        AnnexRepositoryInterface $annexRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->annexRepository = $annexRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(User $auth_user, ?AnnexEntityInterface $annex)
    {
        $this->checkUser($auth_user);
        $this->checkAnnex($annex);

        return $this->annexRepository->delete($annex);
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (!$this->userRepository->isSupport($user)) {
            throw new UserIsNotSupportException();
        }

        return true;
    }

    private function checkAnnex($annex)
    {
        if (is_null($annex)) {
            throw new AnnexIsNotFoundException();
        }
    }
}
