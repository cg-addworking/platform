<?php

namespace App\Http\Controllers\Support\Enterprise;

use App\Models\Addworking\Enterprise\LegalForm;
use App\Http\Requests\Addworking\Enterprise\LegalForm\StoreLegalFormRequest;
use App\Http\Requests\Addworking\Enterprise\LegalForm\UpdateLegalFormRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Addworking\Enterprise\LegalFormRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;

class LegalFormController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(LegalFormRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $items = $this->getPaginatorFromRequest($request);

        return view('addworking.enterprise.legal_form.index', compact('items'));
    }

    public function create()
    {
        $legal_form = $this->repository->make();

        return view('addworking.enterprise.legal_form.create', compact('legal_form'));
    }

    public function store(StoreLegalFormRequest $request)
    {
        $legal_form = $this->repository->createFromRequest($request);

        return $this->redirectWhen($legal_form->exists, $legal_form->routes->show);
    }

    public function show(LegalForm $legal_form)
    {
        return view('addworking.enterprise.legal_form.show', compact('legal_form'));
    }

    public function edit(LegalForm $legal_form)
    {
        return view('addworking.enterprise.legal_form.edit', compact('legal_form'));
    }

    public function update(UpdateLegalFormRequest $request, LegalForm $legal_form)
    {
        $legal_form = $this->repository->updateFromRequest($request, $legal_form);

        return $this->redirectWhen($legal_form->exists, $legal_form->routes->show);
    }

    public function destroy(LegalForm $legal_form)
    {
        $deleted = $this->repository->delete($legal_form);

        return $this->redirectWhen($deleted, $legal_form->routes->index);
    }

    public function getAvailableLegalForms(Request $request)
    {
        $request->validate([
           'country' => 'required|string|max:2'
        ]);

        if ($request->ajax()) {
            $legal_forms = LegalForm::where('country', $request->input('country'))->get();
            $response = [
                'status' => 200,
                'data' => $legal_forms->pluck('display_name', 'id'),
            ];

            return response()->json($response);
        }

        abort(501);
    }
}
