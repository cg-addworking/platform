<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsArchivedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsPublishedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelPartIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\ContractModelVariableIsMalformedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelPartRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelVariableRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;

class EditContractModelPart
{
    private $contractModelPartRepository;
    private $contractModelRepository;
    private $contractModelVariableRepository;
    private $userRepository;

    public function __construct(
        ContractModelPartRepositoryInterface $contractModelPartRepository,
        ContractModelRepositoryInterface $contractModelRepository,
        ContractModelVariableRepositoryInterface $contractModelVariableRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->contractModelPartRepository = $contractModelPartRepository;
        $this->contractModelRepository = $contractModelRepository;
        $this->contractModelVariableRepository = $contractModelVariableRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(
        User $auth_user,
        ContractModelPartEntityInterface $contract_model_part,
        array $inputs,
        $file = null
    ) {
        $this->checkUser($auth_user);
        $this->checkContractModelPart($contract_model_part);

        $contract_model_part = $this->setValues($contract_model_part, $inputs);

        if ($inputs['is_signed']) {
            $contract_model_part->setSignOnLastPage(
                array_key_exists('sign_on_last_page', $inputs) ?
                    $inputs['sign_on_last_page'] :
                    false
            );
            $contract_model_part->setSignaturePage($inputs['signature_page']);
        }

        if ($contract_model_part->getShouldCompile()) {
            $contract_model_part->setText($inputs['textarea']);

            $variables = $this->contractModelVariableRepository->findVariables($inputs['textarea']);
            $this->checkVariables($variables);

            $html = $this->contractModelPartRepository->formatTextForPdf($inputs['textarea']);

            $this->contractModelVariableRepository->refreshVariables($contract_model_part, $variables);

            $file = $this->contractModelPartRepository->createFile($html, true);
            $contract_model_part->setFile($file);
        } elseif (! is_null($file)) {
            $file = $this->contractModelPartRepository->createFile($file);
            $contract_model_part->setFile($file);
        }

        return $this->contractModelPartRepository->save($contract_model_part);
    }

    private function setValues($contract_model_part, $inputs): ContractModelPartEntityInterface
    {
        $contract_model_part->setDisplayName($inputs['display_name']);
        $contract_model_part->setName($inputs['display_name']);
        $contract_model_part->setIsInitialled($inputs['is_initialled']);
        $contract_model_part->setOrder($inputs['order']);
        $contract_model_part->setIsSigned($inputs['is_signed']);
        $contract_model_part->setSignaturePage($inputs['signature_page']);
        $contract_model_part->setIsSigned($inputs['is_signed']);

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

    private function checkContractModelPart($contract_model_part)
    {
        if (is_null($contract_model_part)) {
            throw new ContractModelPartIsNotFoundException();
        }

        $contract_model = $contract_model_part->getContractModel();

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
