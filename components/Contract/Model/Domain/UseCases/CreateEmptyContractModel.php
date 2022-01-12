<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Exceptions\EnterpriseIsNotFound;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelPartyRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;

class CreateEmptyContractModel
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

    public function handle(User $authUser, array $inputs)
    {
        $this->checkUser($authUser);
        $enterprise = $this->enterpriseRepository->find($inputs['enterprise']);
        $this->checkEnterprise($enterprise);

        $contract_model = $this->contractModelRepository->make();

        $contract_model->setEnterprise($enterprise);
        $contract_model->setDisplayName($inputs['display_name']);
        $contract_model->setName($inputs['display_name']);
        $contract_model->setShouldVendorsFillTheirVariables(
            array_key_exists('should_vendors_fill_their_variables', $inputs)
            && $inputs['should_vendors_fill_their_variables']
        );
        $contract_model->setNumber();

        $created = $this->contractModelRepository->save($contract_model);

        $order = 1;
        foreach ($inputs['parties'] as $party_denomination) {
            $contract_model_party = $this->contractModelPartyRepository->make();
            $contract_model_party->setContractModel($created);
            $contract_model_party->setDenomination($party_denomination);
            $contract_model_party->setOrder($order);
            $position = $this->contractModelPartyRepository->calculateSignaturePosition($order);
            $contract_model_party->setSignaturePosition($position);
            $contract_model_party->setNumber();
            $this->contractModelPartyRepository->save($contract_model_party);
            $order++;
        }

        return $created;
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

    private function checkEnterprise($enterprise)
    {
        if (is_null($enterprise)) {
            throw new EnterpriseIsNotFound();
        }
    }
}
