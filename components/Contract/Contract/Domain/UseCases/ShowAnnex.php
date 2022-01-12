<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\AnnexIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportOrMemberOfTheAnnexEnterpriseException;
use Components\Contract\Contract\Domain\Interfaces\Entities\AnnexEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;

class ShowAnnex
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $authUser
     * @param AnnexEntityInterface|null $annex
     * @return AnnexEntityInterface|null
     * @throws AnnexIsNotFoundException
     * @throws UserIsNotAuthenticatedException
     * @throws UserIsNotSupportOrMemberOfTheAnnexEnterpriseException
     */
    public function handle(User $authUser, ?AnnexEntityInterface $annex)
    {
        $annex_enterprise = ! is_null($annex) ? $annex->getEnterprise() : null;

        $this->checkUser($authUser, $annex_enterprise);
        $this->checkAnnex($annex);

        return $annex;
    }

    /**
     * @param User|null $user
     * @param Enterprise|null $enterprise
     * @throws UserIsNotAuthenticatedException
     * @throws UserIsNotSupportOrMemberOfTheAnnexEnterpriseException
     */
    private function checkUser(?User $user, ?Enterprise $enterprise)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (! $this->userRepository->isSupport($user)
            && (! is_null($enterprise) && ! $this->userRepository->checkIfUserIsMember($user, $enterprise))
        ) {
            throw new UserIsNotSupportOrMemberOfTheAnnexEnterpriseException();
        }
    }

    /**
     * @param AnnexEntityInterface|null $annex
     * @throws AnnexIsNotFoundException
     */
    private function checkAnnex(?AnnexEntityInterface $annex)
    {
        if (is_null($annex)) {
            throw new AnnexIsNotFoundException();
        }
    }
}
