<?php

namespace Components\Enterprise\Document\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\Document\Application\Models\DocumentType;
use Components\Enterprise\Document\Application\Models\DocumentTypeRejectReason;
use Components\Enterprise\Document\Application\Repositories\UserRepository;
use Components\Enterprise\Document\Domain\UseCases\DeleteDocumentTypeRejectReason;
use Components\Enterprise\Document\Application\Requests\EditDocumentTypeRejectReasonRequest;
use Components\Enterprise\Document\Domain\UseCases\ListDocumentTypeRejectReason;
use Components\Enterprise\Document\Domain\UseCases\UpdateDocumentTypeRejectReason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Components\Enterprise\Document\Application\Repositories\DocumentTypeRejectReasonRepository;
use Components\Enterprise\Document\Domain\UseCases\CreateDocumentTypeRejectReason;
use Components\Enterprise\Document\Application\Requests\StoreDocumentTypeRejectReasonRequest;

class DocumentTypeRejectReasonController extends Controller
{
    private $userRepository;
    private $documentTypeRejectReasonRepository;

    public function __construct(
        UserRepository $userRepository,
        DocumentTypeRejectReasonRepository $documentTypeRejectReasonRepository
    ) {
        $this->userRepository = $userRepository;
        $this->documentTypeRejectReasonRepository = $documentTypeRejectReasonRepository;
    }

    public function index(Request $request, Enterprise $enterprise, DocumentType $document_type)
    {
        $this->authorize('index', DocumentTypeRejectReason::class);

        $user = $this->userRepository->connectedUser();

        $items = App::make(ListDocumentTypeRejectReason::class)
            ->handle($user, $document_type, $request->input('per-page'));

        return view(
            'document::document_type_reject_reason.index',
            compact('items', 'enterprise', 'document_type')
        );
    }

    public function delete(
        Enterprise $enterprise,
        DocumentType $document_type,
        DocumentTypeRejectReason $document_type_reject_reason
    ) {
        $this->authorize('delete', DocumentTypeRejectReason::class);

        $user = $this->userRepository->connectedUser();

        $deleted = App::make(DeleteDocumentTypeRejectReason::class)
            ->handle($user, $document_type_reject_reason);

        return $this->redirectWhen(
            $deleted,
            route('support.document_type_reject_reason.index', [$enterprise, $document_type])
        );
    }

    public function create(Enterprise $enterprise, DocumentType $document_type)
    {
        $this->authorize('create', DocumentTypeRejectReason::class);

        $document_type_reject_reason = $this->documentTypeRejectReasonRepository->make();

        return view(
            'document::document_type_reject_reason.create',
            compact('enterprise', 'document_type', 'document_type_reject_reason')
        );
    }

    public function store(
        StoreDocumentTypeRejectReasonRequest $request,
        Enterprise $enterprise,
        DocumentType $document_type
    ) {
        $this->authorize('create', DocumentTypeRejectReason::class);

        $document_type_reject_reason = App::make(CreateDocumentTypeRejectReason::class)->handle(
            $this->userRepository->connectedUser(),
            $request->input('document_type_reject_reason'),
            $document_type
        );

        return $this->redirectWhen(
            $document_type_reject_reason->exists,
            route('support.document_type_reject_reason.index', [$enterprise, $document_type])
        );
    }

    public function edit(
        Enterprise $enterprise,
        DocumentType $document_type,
        DocumentTypeRejectReason $document_type_reject_reason
    ) {
        $this->authorize('edit', $document_type_reject_reason);

        return view(
            'document::document_type_reject_reason.edit',
            compact('enterprise', 'document_type', 'document_type_reject_reason')
        );
    }

    public function update(
        EditDocumentTypeRejectReasonRequest $request,
        Enterprise $enterprise,
        DocumentType $document_type,
        DocumentTypeRejectReason $document_type_reject_reason
    ) {
        $this->authorize('edit', $document_type_reject_reason);

        $document_type_reject_reason = App::make(UpdateDocumentTypeRejectReason::class)->handle(
            $this->userRepository->connectedUser(),
            $request->input('document_type_reject_reason'),
            $document_type_reject_reason,
            $document_type
        );

        return $this->redirectWhen(
            $document_type_reject_reason->exists,
            route('support.document_type_reject_reason.index', [$enterprise, $document_type])
        );
    }

    public function getAvailableRejectReasonAjax(Request $request, Enterprise $enterprise, DocumentType $documentType)
    {
        $request->validate([
            'reject_reason_id'    => 'required|uuid|exists:addworking_enterprise_document_reject_reasons,id',
        ]);

        if ($request->ajax()) {
            $message = $this->documentTypeRejectReasonRepository->find($request->input('reject_reason_id'))
                ->getMessage();

            $response = [
                'status' => 200,
                'data' => $message,
            ];

            return response()->json($response);
        }

        abort(501);
    }
}
