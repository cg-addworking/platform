<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\UseCases;

use Components\Common\WYSIWYG\Domain\Interfaces\Repositories\WysiwygRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeIsNotFoundException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeModelVariableIsMalformedException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\DocumentTypeModelRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\DocumentTypeModelVariableRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\UserRepositoryInterface;
use Illuminate\Support\Collection;

class CreateDocumentTypeModel
{
    private $documentTypeModelRepository;
    private $documentTypeModelVariableRepository;
    private $wysiwygRepository;
    private $userRepository;

    public function __construct(
        DocumentTypeModelRepositoryInterface $documentTypeModelRepository,
        DocumentTypeModelVariableRepositoryInterface $documentTypeModelVariableRepository,
        WysiwygRepositoryInterface $wysiwygRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->documentTypeModelRepository = $documentTypeModelRepository;
        $this->documentTypeModelVariableRepository = $documentTypeModelVariableRepository;
        $this->wysiwygRepository = $wysiwygRepository;
        $this->userRepository = $userRepository;
    }

    public function handle($auth_user, $document_type, array $inputs)
    {
        $this->checkUser($auth_user);
        $this->checkDocumentType($document_type);

        $document_type_model = $this->documentTypeModelRepository->make();
        $document_type_model->setDocumentType($document_type);
        $document_type_model->setDisplayName($inputs['display_name']);
        $document_type_model->setName($inputs['display_name']);
        $document_type_model->setDescription($inputs['description']);
        $document_type_model->setShortId();

        if (isset($inputs['signature_page'])) {
            $document_type_model->setSignaturePage($inputs['signature_page']);
        }

        if (isset($inputs['is_primary'])) {
            $document_type_model->setIsPrimary((bool)$inputs['is_primary']);
        }

        if (isset($inputs['requires_documents'])) {
            $document_type_model->setRequiresDocuments((bool)$inputs['requires_documents']);
        }

        $content = $this->documentTypeModelRepository->transformVariableToSnakeFormat($inputs['content']);
        $variables = $this->documentTypeModelVariableRepository->findVariables($content);

        $document_type_model->setContent($content);
        $html = $this->wysiwygRepository->formatTextForPdf($content);
        $file = $this->wysiwygRepository->createFile($html);

        $document_type_model->setFile($file);

        $document_type_model = $this->documentTypeModelRepository->save($document_type_model);

        if (isset($variables)) {
            foreach ($variables as $variable) {
                $this->documentTypeModelVariableRepository->setVariable($variable, $document_type_model);
            }
        }

        return $document_type_model;
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (! $this->userRepository->isSupport($user)) {
            throw new UserIsNotSupportException;
        }
    }

    private function checkDocumentType($document_type)
    {
        if (is_null($document_type)) {
            throw new DocumentTypeIsNotFoundException;
        }
    }
}
