<?php

namespace Components\Enterprise\DocumentTypeModel\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeModelRepository;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\CreateDocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\DeleteDocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\ListDocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\ShowDocumentTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\EditDocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Application\Requests\WysiwygPreviewRequest;
use Components\Common\WYSIWYG\Application\Repositories\WysiwygRepository;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\PublishDocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\UnpublishDocumentTypeModel;
use Components\Infrastructure\PdfManager\Application\PdfManager;

class DocumentTypeModelController extends Controller
{
    private $documentTypeModelRepository;

    public function __construct(DocumentTypeModelRepository $documentTypeModelRepository)
    {
        $this->documentTypeModelRepository = $documentTypeModelRepository;
    }

    public function index(Enterprise $enterprise, DocumentType $document_type)
    {
        $this->authorize('create', DocumentTypeModel::class);

        $items = App::make(ListDocumentTypeModel::class)->handle(Auth::User(), $document_type);

        return view(
            'document_type_model::document_type_model.index',
            compact('items', 'document_type', 'enterprise')
        );
    }

    public function create(Enterprise $enterprise, DocumentType $document_type)
    {
        $this->authorize('create', DocumentTypeModel::class);

        $document_type_model = $this->documentTypeModelRepository->make();

        return view(
            'document_type_model::document_type_model.create',
            compact('document_type_model', 'document_type', 'enterprise')
        );
    }

    public function store(Enterprise $enterprise, DocumentType $document_type, Request $request)
    {
        $this->authorize('create', DocumentTypeModel::class);

        $document_type_model = App::make(CreateDocumentTypeModel::class)->handle(
            $request->user(),
            $document_type,
            $request->input('document_type_model')
        );

        return $this->redirectWhen(
            $document_type_model->exists,
            route('document_type_model.show', [$enterprise, $document_type, $document_type_model])
        );
    }

    public function show(Enterprise $enterprise, DocumentType $document_type, DocumentTypeModel $document_type_model)
    {
        $this->authorize('show', $document_type_model);

        $document_type_model = App::make(ShowDocumentTypeModel::class)
            ->handle(Auth::User(), $document_type_model);

        return view(
            'document_type_model::document_type_model.show',
            compact('enterprise', 'document_type', 'document_type_model')
        );
    }

    public function delete(Enterprise $enterprise, DocumentType $document_type, DocumentTypeModel $document_type_model)
    {
        $this->authorize('delete', $document_type_model);

        $deleted = App::make(DeleteDocumentTypeModel::class)
            ->handle(Auth::user(), $document_type_model);

        return $this->redirectWhen(
            $deleted,
            route('document_type_model.index', [$enterprise, $document_type])
        );
    }

    public function edit(Enterprise $enterprise, DocumentType $document_type, DocumentTypeModel $document_type_model)
    {
        $this->authorize('edit', $document_type_model);

        return view(
            'document_type_model::document_type_model.edit',
            compact('enterprise', 'document_type', 'document_type_model')
        );
    }

    public function update(
        Request $request,
        Enterprise $enterprise,
        DocumentType $document_type,
        DocumentTypeModel $document_type_model
    ) {
        $this->authorize('edit', $document_type_model);

        $document_type_model = App::make(EditDocumentTypeModel::class)->handle(
            $request->user(),
            $document_type_model,
            $request->input('document_type_model')
        );

        return $this->redirectWhen(
            $document_type_model->exists,
            route('document_type_model.show', [$enterprise, $document_type, $document_type_model])
        );
    }

    public function wysiwygPreview(WysiwygPreviewRequest $request, DocumentTypeModel $document_type_model)
    {
        $this->authorize('showWysiwygPreview', $document_type_model);

        if ($request->ajax()) {
            $html = App::make(WysiwygRepository::class)->formatTextForPdf($request->get('content'));

            $pdf = App::make(PdfManager::class)->htmlToPdf($html, "preview");

            return response()->json([
                'status' => 200,
                'data' => base64_encode($pdf->output()),
            ]);
        }

        abort(501);
    }

    public function publish(Enterprise $enterprise, DocumentType $document_type, DocumentTypeModel $document_type_model)
    {
        $this->authorize('publish', $document_type_model);

        $document_type_model =  App::make(PublishDocumentTypeModel::class)->handle(
            Auth::user(),
            $document_type_model
        );

        return $this->redirectWhen(
            $document_type_model->exists,
            route('document_type_model.show', [$enterprise, $document_type, $document_type_model])
        );
    }

    public function unpublish(
        Enterprise $enterprise,
        DocumentType $document_type,
        DocumentTypeModel $document_type_model
    ) {
            $this->authorize('unpublish', $document_type_model);
            
            $document_type_model =  App::make(UnpublishDocumentTypeModel::class)->handle(
                Auth::user(),
                $document_type_model
            );
        
        return $this->redirectWhen(
            $document_type_model->exists,
            route('document_type_model.show', [$enterprise, $document_type, $document_type_model])
        );
    }
}
