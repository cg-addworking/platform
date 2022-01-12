<?php

namespace App\Http\Controllers\Support\Enterprise;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Document;
use App\Repositories\Addworking\Enterprise\DocumentRepository;
use App\Builders\Addworking\Enterprise\DocumentCsvBuilder;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(DocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->authorize('indexSupport', Document::class);

        $items = $this->getPaginatorFromRequest($request, function ($query) use ($request) {
            $query->whereHas('enterprise', function ($query) {
                return $query->withoutTrashed();
            });
        });

        return view('support.enterprise.document.index', @compact('items'));
    }

    public function export(Request $request, DocumentCsvBuilder $builder)
    {
        $items = $this->repository->list($request->input('search'), $request->input('filter'))->cursor();

        return $builder->addAll($items)->download();
    }
}
