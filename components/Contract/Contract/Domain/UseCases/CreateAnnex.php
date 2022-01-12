<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Contract\Domain\Interfaces\Repositories\AnnexRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;

class CreateAnnex
{
    private UserRepositoryInterface $userRepository;
    private AnnexRepositoryInterface $annexRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AnnexRepositoryInterface $annexRepository
    ) {
        $this->userRepository = $userRepository;
        $this->annexRepository = $annexRepository;
    }

    /**
     * @param User $auth_user
     * @param Enterprise $enterprise
     * @param $file
     * @param array $input
     * @return \Components\Contract\Contract\Domain\Interfaces\Entities\AnnexEntityInterface
     * @throws UserIsNotAuthenticatedException
     */
    public function handle(User $auth_user, Enterprise $enterprise, $file, array $input)
    {
        $this->check($auth_user);

        $annex = $this->annexRepository->make();
        $annex->setFile($this->annexRepository->createFile($file));
        $annex->setEnterprise($enterprise);
        $annex->setName($input['name']);
        $annex->setDisplayName($input['name']);
        $annex->setDescription($input['description']);
        $annex->setNumber();
        $this->annexRepository->save($annex);

        return $annex;
    }

    private function check(User $user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (!$this->userRepository->isSupport($user)) {
            throw new UserIsNotSupportException();
        }
    }
}
