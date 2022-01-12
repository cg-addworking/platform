<?php

namespace Components\Enterprise\Enterprise\Application\Controllers;

use App\Http\Controllers\Controller;
use Components\Enterprise\Enterprise\Application\Models\Company;
use Components\Enterprise\Enterprise\Application\Repositories\CompanyRepository;
use Components\Enterprise\Enterprise\Application\Repositories\UserRepository;
use Components\Enterprise\Enterprise\Domain\UseCases\ListCompanies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    private $companyRepository;
    private $userRepository;

    public function __construct(
        CompanyRepository $companyRepository,
        UserRepository $userRepository
    ) {
        $this->companyRepository = $companyRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        // todo : afficher le identification_number , getName
        $this->authorize('index', Company::class);

        $items = App::make(ListCompanies::class)
            ->handle(
                Auth::user(),
                $request->input('filter'),
                $request->input('search'),
                $request->input('per-page'),
                $request->input('operator'),
                $request->input('field')
            );

        $searchable_attributes = $this->companyRepository->getSearchableAttributes();

        return view('enterprise::company.index', compact('items', 'searchable_attributes'));
    }

    public function show(Company $company)
    {
        $this->authorize('show', $company);

        return view('enterprise::company.show', compact('company'));
    }
}
