<?php

namespace Components\Enterprise\DocumentTypeModel\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\Document\Application\Models\Document;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModelVariable;
use Components\Enterprise\DocumentTypeModel\Domain\Entities\DocumentTypeModelEntityInterface;
use Components\Enterprise\DocumentTypeModel\Domain\Entities\DocumentTypeModelVariableEntityInterface;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeModelVariableCreationFailedException;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\DocumentTypeModelVariableRepositoryInterface;
use Illuminate\Support\Collection;

class DocumentTypeModelVariableRepository implements DocumentTypeModelVariableRepositoryInterface
{
    public function make(): DocumentTypeModelVariableEntityInterface
    {
        return new DocumentTypeModelVariable;
    }

    public function save(DocumentTypeModelVariableEntityInterface $document_type_model_variable)
    {
        try {
            $document_type_model_variable->save();
        } catch (DocumentTypeModelVariableCreationFailedException $exception) {
            throw $exception;
        }

        $document_type_model_variable->refresh();

        return $document_type_model_variable;
    }

    public function get(DocumentTypeModel $document_type_model)
    {
        return DocumentTypeModelVariable::whereHas('documentTypeModel', function ($q) use ($document_type_model) {
            return $q->whereId($document_type_model->getId());
        })->get();
    }

    public function find(string $id)
    {
        return DocumentTypeModelVariable::where('id', $id)->first();
    }

    public function findVariables(string $content): array
    {
        $pattern = "#\{\{\s*(.*?)\s*\}\}#";

        $variables = [];

        if (preg_match_all($pattern, $content, $matches)) {
            foreach ($matches[1] as $variable) {
                if (!in_array($variable, $variables)) {
                    $variables[] = $variable;
                }
            }
        }

        return $variables;
    }

    public function setVariable(string $variable, DocumentTypeModelEntityInterface $document_type_model)
    {
        $name = str_slug($variable, '_');

        $document_type_model_variable = $this->make();
        $document_type_model_variable->setShortId();
        $document_type_model_variable->setName($name);
        $document_type_model_variable->setDisplayName($variable);
        $document_type_model_variable->setDocumentTypeModel($document_type_model->getId());

        return $this->save($document_type_model_variable);
    }

    public function variableExists(
        DocumentTypeModelEntityInterface $document_type_model,
        string $name
    ) {
        return DocumentTypeModelVariable::whereHas('documentTypeModel', function ($q) use ($document_type_model) {
            $q->where('id', $document_type_model->getId());
        })->where('name', $name)
            ->count() >= 1;
    }

    public function delete(DocumentTypeModelVariableEntityInterface $document_type_model_variable): bool
    {
        return $document_type_model_variable->delete();
    }

    public function list(DocumentTypeModel $document_type_model)
    {
        return DocumentTypeModelVariable::query()
            ->whereHas('documentTypeModel', function ($query) use ($document_type_model) {
                $query->where('id', $document_type_model->getId());
            })->paginate(25);
    }

    public function getAvailableInputTypes(bool $trans = false): array
    {
        $translation_base = "components.contract.model.application.models.contract_model_variable.input_type";

        $input_types =  [
            __("{$translation_base}.enterprise_title") => [
                DocumentTypeModelVariable::INPUT_TYPE_ENTERPRISE_LEGAL_FORM =>
                    __("{$translation_base}.enterprise_legal_form"),
                DocumentTypeModelVariable::INPUT_TYPE_ENTERPRISE_NAME =>
                    __("{$translation_base}.enterprise_name"),
                DocumentTypeModelVariable::INPUT_TYPE_ENTERPRISE_ADDRESS =>
                    __("{$translation_base}.enterprise_address"),
                DocumentTypeModelVariable::INPUT_TYPE_ENTERPRISE_TOWN =>
                    __("{$translation_base}.enterprise_town"),
                DocumentTypeModelVariable::INPUT_TYPE_ENTERPRISE_IDENTIFICATION_NUMBER =>
                    __("{$translation_base}.enterprise_identification_number"),
                DocumentTypeModelVariable::INPUT_TYPE_ENTERPRISE_SIREN_NUMBER =>
                    __("{$translation_base}.enterprise_siren_number"),
                DocumentTypeModelVariable::INPUT_TYPE_ENTERPRISE_REGISTRATION_TOWN =>
                    __("{$translation_base}.registration_town"),
                DocumentTypeModelVariable::INPUT_TYPE_ENTERPRISE_REGISTRATION_DATE =>
                    __("{$translation_base}.enterprise_registration_date"),
                DocumentTypeModelVariable::INPUT_TYPE_ENTERPRISE_EMPLOYEES_NUMBER =>
                    __("{$translation_base}.enterprise_employees_number"),
            ],
            __("{$translation_base}.signatory_title") => [
                DocumentTypeModelVariable::INPUT_TYPE_SIGNATORY_NAME =>
                    __("{$translation_base}.signatory_name"),
                DocumentTypeModelVariable::INPUT_TYPE_SIGNATORY_MAIL =>
                    __("{$translation_base}.signatory_mail"),
                DocumentTypeModelVariable::INPUT_TYPE_SIGNATORY_FUNCTION =>
                    __("{$translation_base}.signatory_function"),
            ],
        ];

        return $trans ? $input_types : array_keys($input_types);
    }

    public function isDate(DocumentTypeModelVariableEntityInterface $document_type_model_variable): bool
    {
        return in_array(
            $document_type_model_variable->getInputType(),
            [DocumentTypeModelVariableEntityInterface::INPUT_TYPE_DATE,]
        );
    }

    public function isEditable(DocumentTypeModelVariableEntityInterface $document_type_model_variable): bool
    {
        return ! in_array($document_type_model_variable->getInputType(), [
            DocumentTypeModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_NAME,
            DocumentTypeModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_ADDRESS,
            DocumentTypeModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_TOWN,
            DocumentTypeModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_IDENTIFICATION_NUMBER,
            DocumentTypeModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_LEGAL_FORM,
            DocumentTypeModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_SIREN_NUMBER,
            DocumentTypeModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_REGISTRATION_TOWN,
            DocumentTypeModelVariableEntityInterface::INPUT_TYPE_SIGNATORY_NAME,
            DocumentTypeModelVariableEntityInterface::INPUT_TYPE_SIGNATORY_MAIL,
            DocumentTypeModelVariableEntityInterface::INPUT_TYPE_SIGNATORY_FUNCTION,
        ]);
    }

    public function findByShortId(int $short_id): ?DocumentTypeModelVariableEntityInterface
    {
        return DocumentTypeModelVariable::whereShortId($short_id)->first();
    }

    public function setVariableValue(
        DocumentTypeModelVariableEntityInterface $document_type_model_variable,
        ?Enterprise $enterprise,
        ?User $user
    ) {
        switch ($document_type_model_variable->getInputType()) {
            case (DocumentTypeModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_LEGAL_FORM):
                $value = $enterprise->legalForm->display_name;
                break;
            case (DocumentTypeModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_NAME):
                $value = $enterprise->name;
                break;
            case (DocumentTypeModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_ADDRESS):
                $value = $enterprise->address->one_line;
                break;
            case (DocumentTypeModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_TOWN):
                $value = $enterprise->address->town;
                break;
            case (DocumentTypeModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_IDENTIFICATION_NUMBER):
                $value = $enterprise->identification_number;
                break;
            case (DocumentTypeModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_SIREN_NUMBER):
                $value = $enterprise->siren;
                break;
            case (DocumentTypeModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_REGISTRATION_TOWN):
                $value = $enterprise->registration_town;
                break;
            case (DocumentTypeModelVariableEntityInterface::INPUT_TYPE_SIGNATORY_NAME):
                $value = $user->name;
                break;
            case (DocumentTypeModelVariableEntityInterface::INPUT_TYPE_SIGNATORY_FUNCTION):
                $value = $user->getJobTitleFor($enterprise);
                break;
            case (DocumentTypeModelVariableEntityInterface::INPUT_TYPE_SIGNATORY_MAIL):
                $value = $user->email;
                break;
            case (DocumentTypeModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_REGISTRATION_DATE):
                $registration_date = $enterprise->getRegistrationDate();
                $value = $registration_date ? $registration_date->format('d/m/Y') : null;
                break;
            case (DocumentTypeModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_EMPLOYEES_NUMBER):
                $value = $enterprise->activities()->get()->sum('employees_count');
                break;
            default:
                $value = $document_type_model_variable->getDefaultValue();
        }

        return $value;
    }
}
