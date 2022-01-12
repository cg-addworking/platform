<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\UseCases;

use Illuminate\Support\Collection;
use App\Models\Addworking\User\User;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Common\WYSIWYG\Domain\Interfaces\Repositories\WysiwygRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\UserRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeModelIsNotFoundException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeModelVariableIsMalformedException;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\DocumentTypeModelRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\DocumentTypeModelVariableRepositoryInterface;

class EditDocumentTypeModel
{
    private $documentTypeModelRepository;
    private $documentTypeModelVariableRepository;
    private $wysiwygRepository;
    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        DocumentTypeModelRepositoryInterface $documentTypeModelRepository,
        DocumentTypeModelVariableRepositoryInterface $documentTypeModelVariableRepository,
        WysiwygRepositoryInterface $wysiwygRepository
    ) {
        $this->userRepository = $userRepository;
        $this->documentTypeModelRepository = $documentTypeModelRepository;
        $this->documentTypeModelVariableRepository = $documentTypeModelVariableRepository;
        $this->wysiwygRepository = $wysiwygRepository;
    }

    public function handle(User $auth_user, $model, array $inputs)
    {
        $this->checkUser($auth_user);
        $this->checkDocumentTypeModel($model);

        $model->setDescription($inputs['description']);
        $model->setDisplayName($inputs['display_name']);
        $model->setName(str_slug($inputs['display_name'], "_"));

        if (isset($inputs['signature_page'])) {
            $model->setSignaturePage($inputs['signature_page']);
        }

        if (isset($inputs['is_primary'])) {
            $model->setIsPrimary((bool)$inputs['is_primary']);
        }

        if (isset($inputs['requires_documents'])) {
            $model->setRequiresDocuments((bool)$inputs['requires_documents']);
        } else {
            $model->setRequiresDocuments(false);
        }

        $this->deleteVariables($model);

        $content = $this->documentTypeModelRepository->transformVariableToSnakeFormat($inputs['content']);
        $variables = $this->documentTypeModelVariableRepository->findVariables($content);

        $model->setContent($content);
        $html = $this->wysiwygRepository->formatTextForPdf($content);
        $model->setFile($this->wysiwygRepository->createFile($html, true));

        $document_type_model = $this->documentTypeModelRepository->save($model);

        if (isset($variables)) {
            foreach ($variables as $variable) {
                $this->documentTypeModelVariableRepository->setVariable($variable, $document_type_model);
            }
        }

        return $document_type_model;
    }

    private function checkUser(User $user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (! $this->userRepository->isSupport($user)) {
            throw new UserIsNotSupportException;
        }
    }

    private function checkDocumentTypeModel(?DocumentTypeModel $document_type_model)
    {
        if (is_null($document_type_model)) {
            throw new DocumentTypeModelIsNotFoundException;
        }
    }

    private function deleteVariables(?DocumentTypeModel $document_type_model)
    {
        if ($this->documentTypeModelRepository->checkIfModelHasVariable($document_type_model)) {
            foreach ($document_type_model->getVariables() as $variable) {
                $this->documentTypeModelVariableRepository->delete($variable);
            }
        }
    }
}
