<?php

namespace Components\Enterprise\DocumentTypeModel\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Model\Application\Repositories\UserRepository;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModelVariable;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\DocumentTypeModelVariableRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\CreateDocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\EditDocumentTypeModelVariable;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\ListDocumentTypeModelVariable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class DocumentTypeModelVariableController extends Controller
{
    private $userRepository;
    private $documentTypeModelVariableRepository;

    public function __construct(
        UserRepository $userRepository,
        DocumentTypeModelVariableRepositoryInterface $documentTypeModelVariableRepository
    ) {
        $this->userRepository = $userRepository;
        $this->documentTypeModelVariableRepository = $documentTypeModelVariableRepository;
    }

    public function edit(Enterprise $enterprise, DocumentType $document_type, DocumentTypeModel $document_type_model)
    {
        $this->authorize('edit', $document_type_model);

        $items = App::make(ListDocumentTypeModelVariable::class)->handle(
            $this->userRepository->connectedUser(),
            $document_type_model
        );

        $input_types = $this->documentTypeModelVariableRepository->getAvailableInputTypes(true);

        return view(
            'document_type_model::document_type_model_variable.edit',
            compact('items', 'input_types', 'enterprise', 'document_type', 'document_type_model')
        );
    }

    public function update(
        Enterprise $enterprise,
        DocumentType $document_type,
        DocumentTypeModel $document_type_model,
        Request $request
    ) {
        $this->authorize('edit', $document_type_model);

        DB::transaction(function () use ($request) {
            foreach ($request->input('document_type_model_variable') as $id => $inputs) {
                $variable = $this->documentTypeModelVariableRepository->find($id);
                App::make(EditDocumentTypeModelVariable::class)->handle(
                    $this->userRepository->connectedUser(),
                    $variable,
                    $inputs,
                );
            }
        });

        return redirect(route('document_type_model.show', [$enterprise, $document_type, $document_type_model]));
    }
}
