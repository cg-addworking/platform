<?php

namespace App\Http\Controllers\Support\Enterprise;

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

    public function index(Request $request)
    {
        $items = $this->getPaginatorFromRequest($request, null);

        return view('support.enterprise.document_type.index', @compact('items'));
    }
}
