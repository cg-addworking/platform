<?php

namespace App\Http\Controllers\Edenred\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Edenred\Common\Code\StoreCodeRequest;
use App\Http\Requests\Edenred\Common\Code\UpdateCodeRequest;
use App\Models\Edenred\Common\Code;
use App\Repositories\Edenred\Common\CodeRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(CodeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->authorize('index', Code::class);

        $items = $this->getPaginatorFromRequest($request);

        return view('edenred.common.code.index', @compact('items'));
    }

    public function create()
    {
        $this->authorize('create', Code::class);

        $code = $this->repository->make();

        return view('edenred.common.code.create', @compact('code'));
    }

    public function store(StoreCodeRequest $request)
    {
        $code = $this->repository->createFromRequest($request);

        return redirect_when($code->exists, route('edenred.common.code.show', $code));
    }

    public function show(Code $code)
    {
        $this->authorize('view', $code);

        return view('edenred.common.code.show', @compact('code'));
    }

    public function edit(Code $code)
    {
        $this->authorize('update', $code);

        return view('edenred.common.code.edit', @compact('code'));
    }

    public function update(UpdateCodeRequest $request, Code $code)
    {
        $code = $this->repository->updateFromRequest($request, $code);

        return redirect_when($code->exists, route('edenred.common.code.show', $code));
    }

    public function destroy(Code $code)
    {
        $this->authorize('delete', $code);

        $deleted = $this->repository->delete($code);

        return redirect_when($deleted, route('edenred.common.code.index'));
    }
}
