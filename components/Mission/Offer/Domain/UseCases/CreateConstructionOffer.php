<?php

namespace Components\Mission\Offer\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Mission\Offer\Domain\Exceptions\CustomerNotFoundException;
use Components\Mission\Offer\Domain\Exceptions\EnterpriseIsNotAssociatedToConstructionSectorException;
use Components\Mission\Offer\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Mission\Offer\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Mission\Offer\Domain\Exceptions\UserNotFoundException;
use Components\Mission\Offer\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\OfferRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\SectorRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\WorkFieldRepositoryInterface;

class CreateConstructionOffer
{
    private $offerRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $workFieldRepository;
    private $sectorRepository;

    public function __construct(
        OfferRepositoryInterface $offerRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        UserRepositoryInterface $userRepository,
        WorkFieldRepositoryInterface $workFieldRepository,
        SectorRepositoryInterface $sectorRepository
    ) {
        $this->offerRepository = $offerRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->userRepository = $userRepository;
        $this->workFieldRepository = $workFieldRepository;
        $this->sectorRepository = $sectorRepository;
    }

    public function handle(?User $auth_user, array $inputs, $files = [])
    {
        $customer = $this->enterpriseRepository->find($inputs['enterprise_id']);
        $referent = $this->userRepository->find($inputs['referent_id']);

        $this->checkUser($auth_user, $referent);
        $this->checkEnterprise($customer, $auth_user);

        $offer = $this->offerRepository->make();
        $offer->setNumber();
        $offer->setLabel($inputs['label']);
        $offer->setStartsAtDesired($inputs['starts_at_desired']);
        $offer->setEndsAt($inputs['ends_at']);
        $offer->setDescription($inputs['description']);
        $offer->setExternalId($inputs['external_id']);
        $offer->setAnalyticCode($inputs['analytic_code']);
        $offer->setStatus($inputs['status']);
        $offer->setCreatedBy($auth_user);
        $offer->setCustomer($customer);
        $offer->setReferent($referent);

        if (! empty($inputs['response_deadline'])) {
            $offer->setResponseDeadline($inputs['response_deadline']);
        }
        if (! empty($inputs['workfield_id'])) {
            $workfield = $this->workFieldRepository->find($inputs['workfield_id']);
            $offer->setWorkField($workfield);
        }

        $saved = $this->offerRepository->save($offer);

        if (! empty($inputs['departments'])) {
            $offer->setDepartments($inputs['departments']);
        }

        if (! empty($inputs['skills'])) {
            $offer->setSkills($inputs['skills']);
        }

        if (! empty($files)) {
            $this->offerRepository->createFiles($files, $offer);
        }

        return $saved;
    }

    private function checkUser(?User $user, ?User $referent)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (is_null($referent)) {
            throw new UserNotFoundException;
        }
    }

    private function checkEnterprise(?Enterprise $customer, ?User $user)
    {
        if (is_null($customer)) {
            throw new CustomerNotFoundException;
        }

        if (! $customer->isCustomer() && ! $user->isSupport()) {
            throw new EnterpriseIsNotCustomerException;
        }

        if (! $this->sectorRepository->belongsToConstructionSector($customer)) {
            throw new EnterpriseIsNotAssociatedToConstructionSectorException;
        }
    }
}
