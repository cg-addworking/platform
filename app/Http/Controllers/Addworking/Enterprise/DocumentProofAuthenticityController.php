<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\DocumentProofAuthenticityRepository;
use App\Http\Requests\Addworking\Enterprise\Document\StoreDocumentProofAuthenticityRequest;
use Components\Enterprise\Document\Application\Repositories\DocumentRepository;
use Components\Infrastructure\ElectronicSignature\Application\Yousign\Client as Yousign;

class DocumentProofAuthenticityController extends Controller
{
    protected $repository;
    protected $documentRepository;

    public function __construct(
        DocumentProofAuthenticityRepository $repository,
        DocumentRepository $documentRepository
    ) {
        $this->repository = $repository;
        $this->documentRepository = $documentRepository;
    }

    public function create(Enterprise $enterprise, Document $document)
    {
        $this->authorize('createProofAuthenticity', $document);

        return view('addworking.enterprise.document.proof_authenticity.create', compact('enterprise', 'document'));
    }

    public function store(StoreDocumentProofAuthenticityRequest $request, Enterprise $enterprise, Document $document)
    {
        $this->authorize('createProofAuthenticity', $document);

        $document = $this->repository->createFromRequest($request, $document);

        return $this->redirectWhen(
            $document->exists,
            route('addworking.enterprise.document.show', [$enterprise, $document])
        );
    }

    public function download(Enterprise $enterprise, Document $document)
    {
        return $document->getProofAuthenticity()->download();
    }

    public function downloadFromYousign(Enterprise $enterprise, Document $document)
    {
        $client = new Yousign;
        $proof_content = $client->getProofFile($document->getYousignMemberId());

        $file_content = base64_decode($proof_content->body);

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename=proof_of_signature'.uniqid().'.pdf',
        ];

        return response()->stream(function () use ($file_content) {
            echo $file_content;
        }, 200, $headers);
    }

    public function edit(Enterprise $enterprise, Document $document)
    {
        $this->authorize('editProofAuthenticity', $document);

        return view('addworking.enterprise.document.proof_authenticity.edit', compact('enterprise', 'document'));
    }

    public function update(StoreDocumentProofAuthenticityRequest $request, Enterprise $enterprise, Document $document)
    {
        $this->authorize('editProofAuthenticity', $document);

        $document = $this->repository->updateFromRequest($request, $document);

        return $this->redirectWhen(
            $document->exists,
            route('addworking.enterprise.document.show', [$enterprise, $document])
        );
    }
}
