<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\DocumentTypeField;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Http\Requests\Addworking\Enterprise\DocumentTypeField\StoreDocumentTypeFieldRequest;
use App\Http\Requests\Addworking\Enterprise\DocumentTypeField\UpdateDocumentTypeFieldRequest;
use App\Repositories\Addworking\Enterprise\DocumentTypeFieldRepository;

class DocumentTypeFieldController extends Controller
{
    protected $repository;

    public function __construct(DocumentTypeFieldRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(Enterprise $enterprise, DocumentType $type, StoreDocumentTypeFieldRequest $request)
    {
        $field = $this->repository->createFromRequest($request);

        return redirect_when($field->exists, $type->routes->show);
    }

    public function update(
        Enterprise $enterprise,
        DocumentType $type,
        DocumentTypeField $field,
        UpdateDocumentTypeFieldRequest $request
    ) {
        $documentTypeField = $this->repository->updateFromRequest($field, $request);

        return redirect_when($documentTypeField->exists, $type->routes->show);
    }

    public function destroy(Enterprise $enterprise, DocumentType $type, DocumentTypeField $field)
    {
        $this->authorize('destroy', $field);

        $deleted = $field->documentType()->dissociate()->save();

        return redirect_when($deleted, $type->routes->show);
    }
}
