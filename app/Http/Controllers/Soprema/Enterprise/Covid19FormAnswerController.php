<?php

namespace App\Http\Controllers\Soprema\Enterprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Soprema\Enterprise\Covid19FormAnswer\StoreCovid19FormAnswerRequest;
use App\Http\Requests\Soprema\Enterprise\Covid19FormAnswer\UpdateCovid19FormAnswerRequest;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Soprema\Enterprise\Covid19FormAnswer;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use App\Repositories\Soprema\Enterprise\Covid19FormAnswerRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Covid19FormAnswerController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(Covid19FormAnswerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, EnterpriseRepository $enterprise_repository)
    {
        $this->authorize('viewAny', Covid19FormAnswer::class);

        $enterprise = null;

        if ($request->input('enterprise')) {
            $enterprise = $enterprise_repository->find($request->input('enterprise'));
        }

        $items = $this->getPaginatorFromRequest($request, function ($query) use ($request, $enterprise) {
            $query
                ->when($enterprise, fn($query, $enterprise) => $query->ofCustomer($enterprise))
                ->when($request->has('pursuit'), fn($query) => $query->where('pursuit', $request->input('pursuit')));
        });

        $subsidiaries = Enterprise::fromName('SOPREMA ENTREPRISES')->family()->sortBy('name')->pluck('name', 'id');

        return view('soprema.enterprise.covid19_form_answer.index', compact('items', 'subsidiaries', 'enterprise'));
    }

    public function create(Request $request)
    {
        $covid19_form_answer = $this->repository->make();

        if (Auth::check()) {
            $covid19_form_answer->vendor()->associate(Auth::user()->enterprise);
        }

        return view('soprema.enterprise.covid19_form_answer.create', compact('covid19_form_answer'));
    }

    public function login(Request $request)
    {
        Session::put('redirectAfterLogin', route('soprema.enterprise.covid19_form_answer.create'));

        return redirect()->route('login');
    }

    public function store(StoreCovid19FormAnswerRequest $request)
    {
        $covid19_form_answer = $this->repository->createFromRequest($request);

        return $this->redirectWhen($covid19_form_answer->exists, $covid19_form_answer->routes->confirm);
    }

    public function confirm()
    {
        return view('soprema.enterprise.covid19_form_answer.confirm');
    }

    public function show(Covid19FormAnswer $covid19_form_answer)
    {
        $this->authorize('view', $covid19_form_answer);

        return view('soprema.enterprise.covid19_form_answer.show', compact('covid19_form_answer'));
    }

    public function edit(Covid19FormAnswer $covid19_form_answer)
    {
        $this->authorize('update', $covid19_form_answer);

        return view('soprema.enterprise.covid19_form_answer.edit', compact('covid19_form_answer'));
    }

    public function update(UpdateCovid19FormAnswerRequest $request, Covid19FormAnswer $covid19_form_answer)
    {
        $this->authorize('update', $covid19_form_answer);

        $covid19_form_answer = $this->repository->updateFromRequest($request, $covid19_form_answer);

        return $this->redirectWhen($covid19_form_answer->exists, $covid19_form_answer->routes->show);
    }

    public function destroy(Covid19FormAnswer $covid19_form_answer)
    {
        $this->authorize('delete', $covid19_form_answer);

        $deleted = $this->repository->delete($covid19_form_answer);

        return $this->redirectWhen($deleted, $covid19_form_answer->routes->index);
    }
}
