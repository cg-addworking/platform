<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsArchivedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsPublishedException;
use Components\Contract\Model\Domain\Exceptions\EnterpriseIsNotFound;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelPartyRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;

class EditContractModel
{
    private $contractModelPartyRepository;
    private $contractModelRepository;
    private $enterpriseRepository;
    private $userRepository;

    public function __construct(
        ContractModelPartyRepositoryInterface $contractModelPartyRepository,
        ContractModelRepositoryInterface $contractModelRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->contractModelPartyRepository = $contractModelPartyRepository;
        $this->contractModelRepository      = $contractModelRepository;
        $this->enterpriseRepository         = $enterpriseRepository;
        $this->userRepository               = $userRepository;
    }

    public function handle(User $authUser, ContractModelEntityInterface $contract_model, array $inputs)
    {
        $this->checkUser($authUser);
        $this->checkContractModel($contract_model);

        $enterprise = $this->enterpriseRepository->find($inputs['enterprise']);
        $this->checkEnterprise($enterprise);
        $contract_model->setEnterprise($enterprise);

        $contract_model->setDisplayName($inputs['display_name']);
        $contract_model->setName($inputs['display_name']);

        $contract_model->setShouldVendorsFillTheirVariables(
            array_key_exists('should_vendors_fill_their_variables', $inputs)
            && $inputs['should_vendors_fill_their_variables']
        );

        $updated = $this->contractModelRepository->save($contract_model);

        foreach ($inputs['parties'] as $id => $denomination) {
            $contract_model_party = $this->contractModelPartyRepository->find($id);
            $contract_model_party->setDenomination($denomination);
            $this->contractModelPartyRepository->save($contract_model_party);
        }

        return $updated;
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (! $this->userRepository->isSupport($user)) {
            throw new UserIsNotSupportException();
        }
    }

    private function checkContractModel($contract_model)
    {
        if (is_null($contract_model)) {
            throw new ContractModelIsNotFoundException();
        }

        if ($this->contractModelRepository->isPublished($contract_model)) {
            throw new ContractModelIsPublishedException();
        }

        if ($this->contractModelRepository->isArchived($contract_model)) {
            throw new ContractModelIsArchivedException();
        }
    }

    private function checkEnterprise($enterprise)
    {
        if (is_null($enterprise)) {
            throw new EnterpriseIsNotFound();
        }
    }
}
