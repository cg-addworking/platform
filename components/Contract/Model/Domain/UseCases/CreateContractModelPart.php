<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsArchivedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsPublishedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelVariableIsMalformedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelPartRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelPartyRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelVariableRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;

class CreateContractModelPart
{
    private $contractModelPartRepository;
    private $contractModelPartyRepository;
    private $contractModelRepository;
    private $contractModelVariableRepository;
    private $userRepository;

    public function __construct(
        ContractModelPartRepositoryInterface $contractModelPartRepository,
        ContractModelPartyRepositoryInterface $contractModelPartyRepository,
        ContractModelRepositoryInterface $contractModelRepository,
        ContractModelVariableRepositoryInterface $contractModelVariableRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->contractModelPartRepository = $contractModelPartRepository;
        $this->contractModelPartyRepository = $contractModelPartyRepository;
        $this->contractModelRepository = $contractModelRepository;
        $this->contractModelVariableRepository = $contractModelVariableRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(User $auth_user, ContractModelEntityInterface $contract_model, array $inputs, $file = null)
    {
        $this->checkUser($auth_user);
        $this->checkContractModel($contract_model);

        $contract_model_part = $this->contractModelPartRepository->make();
        $contract_model_part->setContractModel($contract_model);
        $contract_model_part->setDisplayName($inputs['display_name']);
        $contract_model_part->setName($inputs['display_name']);
        $contract_model_part->setIsInitialled($inputs['is_initialled']);
        $contract_model_part->setOrder($inputs['order']);
        $contract_model_part->setNumber();

        $contract_model_part->setIsSigned($inputs['is_signed']);
        if ($inputs['is_signed'] === '1') {
            if (array_key_exists('sign_on_last_page', $inputs) && $inputs['sign_on_last_page']) {
                $contract_model_part->setSignOnLastPage($inputs['sign_on_last_page']);
            } else {
                $contract_model_part->setSignaturePage($inputs['signature_page']);
            }
        }

        if (isset($inputs['textarea'])) {
            $variables = $this->contractModelVariableRepository->findVariables($inputs['textarea']);
            $this->checkVariables($variables);

            $contract_model_part->setText($inputs['textarea']);
            $html = $this->contractModelPartRepository->formatTextForPdf($inputs['textarea']);

            $file = $this->contractModelPartRepository->createFile($html, true);
            $contract_model_part->setShouldCompile(true);
        } elseif (! is_null($file)) {
            $file = $this->contractModelPartRepository->createFile($file);
            $contract_model_part->setShouldCompile(false);
        }

        $contract_model_part->setFile($file);

        $contract_model_part = $this->contractModelPartRepository->save($contract_model_part);

        if (isset($inputs['textarea'])) {
            $this->contractModelVariableRepository->setVariables(new Collection($variables), $contract_model_part);
        }

        return $contract_model_part;
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

    private function checkVariables($variables)
    {
        foreach ($variables as $variable) {
            if (count(explode('.', $variable)) !== 2) {
                throw new ContractModelVariableIsMalformedException();
            }
        }
    }
}
