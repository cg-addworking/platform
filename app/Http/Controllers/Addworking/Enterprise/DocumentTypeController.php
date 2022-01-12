<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Enterprise\DocumentType\StoreDocumentTypeRequest;
use App\Http\Requests\Addworking\Enterprise\DocumentType\UpdateDocumentTypeRequest;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\DocumentTypeRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(DocumentTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Enterprise $enterprise, Request $request)
    {
        $this->authorize('index', DocumentType::class);

        $items = $this->getPaginatorFromRequest($request, function ($query) use ($enterprise) {
            $query->with('legalForms')->ofEnterprise($enterprise);
        });

        $document_type = $this->repository->factory()->enterprise()->associate($enterprise);

        return view('addworking.enterprise.document_type.index', @compact('enterprise', 'document_type', 'items'));
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('create', DocumentType::class);

        $document_type = $this->repository->factory()->enterprise()->associate($enterprise);

        return view('addworking.enterprise.document_type.create', @compact('enterprise', 'document_type'));
    }

    public function store(Enterprise $enterprise, StoreDocumentTypeRequest $request)
    {
        $this->authorize('store', DocumentType::class);

        $document_type = $this
            ->repository
            ->createFromRequest($this->mergeNeedsValidationAttributes($request), $enterprise);

        return redirect_when($document_type->exists, $document_type->routes->show);
    }

    public function show(Enterprise $enterprise, DocumentType $type)
    {
        $this->authorize('show', $type);

        return view('addworking.enterprise.document_type.show', @compact('enterprise', 'type'));
    }

    public function edit(Enterprise $enterprise, DocumentType $type)
    {
        return view('addworking.enterprise.document_type.edit', @compact('enterprise', 'type'));
    }

    public function update(UpdateDocumentTypeRequest $request, Enterprise $enterprise, DocumentType $type)
    {
        $this->authorize('update', $type);

        $this->repository->updateFromRequest($type, $this->mergeNeedsValidationAttributes($request), $enterprise);

        return redirect_when($type->exists, $type->routes->show);
    }

    public function destroy(Enterprise $enterprise, DocumentType $type)
    {
        $this->authorize('destroy', $type);

        $deleted = $type->delete();

        return redirect_when(
            $deleted,
            $this->repository->factory()->enterprise()->associate($enterprise)->routes->index
        );
    }

    public function modelStore(Enterprise $enterprise, DocumentType $type, Request $request)
    {
        if ($file = $type->file) {
            $type->file()->dissociate()->save();
            $file->delete();
        }

        $file = File::from($request->file('document.type.file'))
            ->name("/%uniq%-%ts%.%ext%")
            ->saveAndGet();
        $type->file()->associate($file);

        $type->save();

        return redirect_when($type->exists, $type->routes->show);
    }

    protected function mergeNeedsValidationAttributes(Request $request)
    {
        $data = $request->input();

        if ($request->has('type.needs_validation')) {
            $data['type']['needs_customer_validation'] = in_array(
                'needs_customer_validation',
                $request->input('type.needs_validation')
            ) ? true : false;

            $data['type']['needs_support_validation'] = in_array(
                'needs_support_validation',
                $request->input('type.needs_validation')
            ) ? true : false;
        } else {
            $data['type']['needs_customer_validation'] = false;
            $data['type']['needs_support_validation'] = false;
        }

        $request->merge($data);

        return $request;
    }
}
