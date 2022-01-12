<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Common\WYSIWYG\Application\Repositories\WysiwygRepository;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentEntityInterface;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\DocumentRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Domain\Entities\DocumentTypeModelEntityInterface;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeModelIsNotFoundException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\DocumentTypeModelVariableRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\UserRepositoryInterface;
use Components\Infrastructure\PdfManager\Domain\Classes\PdfManagerInterface;

class GenerateDocument
{
    protected $userRepository;
    protected $documentRepository;
    protected $documentTypeModelVariableRepository;
    protected $pdfManager;
    protected $wysiwygRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        DocumentRepositoryInterface $documentRepository,
        DocumentTypeModelVariableRepositoryInterface $documentTypeModelVariableRepository,
        PdfManagerInterface $pdfManager,
        WysiwygRepository $wysiwygRepository
    ) {
        $this->userRepository = $userRepository;
        $this->documentRepository = $documentRepository;
        $this->documentTypeModelVariableRepository = $documentTypeModelVariableRepository;
        $this->pdfManager = $pdfManager;
        $this->wysiwygRepository = $wysiwygRepository;
    }

    public function handle(
        ?User $auth_user,
        ?Enterprise $enterprise,
        ?DocumentTypeModelEntityInterface $document_type_model
    ) {
        $this->check($auth_user, $document_type_model);

        $file = $this->createFileFromHtml($document_type_model, $enterprise, $auth_user);

        $document = $this->documentRepository->make();
        $document->setEnterprise($enterprise);
        $document->setDocumentTypeModel($document_type_model);
        $document->setDocumentType($document_type_model->getDocumentType());
        $document->setStatus(DocumentEntityInterface::STATUS_PENDING_SIGNATURE);
        $document->setValidFrom(Carbon::today());
        $valid_until = Carbon::today()->addDays($document_type_model->getDocumentType()->validity_period - 1);
        $document->setValidUntil($valid_until);

        $this->documentRepository->save($document);

        $document->setFiles($file);

        return $document;
    }

    private function check($auth_user, $document_type_model)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (is_null($document_type_model)) {
            throw new DocumentTypeModelIsNotFoundException();
        }
    }

    private function createFileFromHtml($document_type_model, $enterprise, $user)
    {
        $variables = $this->documentTypeModelVariableRepository->get($document_type_model);
        $html = $document_type_model->getContent();

        foreach ($variables as $variable) {
            $var_name = "{{". $variable->getName() . "}}";
            $value = $this->documentTypeModelVariableRepository->setVariableValue($variable, $enterprise, $user);

            $html = str_replace($var_name, $value, $html);
        }

        $pdf = $this->wysiwygRepository->formatTextForPdf($html);
        return $this->wysiwygRepository->createFile($pdf);
    }
}
