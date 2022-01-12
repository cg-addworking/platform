<?php

namespace Components\Sogetrel\Passwork\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sogetrel\User\Passwork as SogetrelPasswork;
use Components\Sogetrel\Passwork\Application\Models\Acceptation;
use Components\Sogetrel\Passwork\Application\Repositories\AcceptationRepository;
use Components\Sogetrel\Passwork\Application\Repositories\EnterpriseRepository;
use Components\Sogetrel\Passwork\Domain\UseCases\ListAcceptation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class AcceptationController extends Controller
{
    protected $acceptationRepository;
    protected $enterpriseRepository;

    public function __construct(
        AcceptationRepository $acceptationRepository,
        EnterpriseRepository $enterpriseRepository
    ) {
        $this->acceptationRepository = $acceptationRepository;
        $this->enterpriseRepository = $enterpriseRepository;
    }

    public function index(Request $request)
    {
        $this->authorize('index', [Acceptation::class]);

        $items = App::make(ListAcceptation::class)
            ->handle(
                Auth::user(),
                $request->input('filter'),
                $request->input('search'),
                $request->input('per-page'),
                $request->input('operator'),
                $request->input('field')
            );

        $searchable_attributes = $this->acceptationRepository->getSearchableAttributes();

        return view('sogetrel_passwork::acceptation.index', compact('items', 'searchable_attributes'));
    }

    public function create(SogetrelPasswork $passwork)
    {
        $this->authorize('create', [Acceptation::class, $passwork]);

        $vendor_compliance_managers = $this
            ->enterpriseRepository
            ->getCustomerComplianceManagers(Auth::user()->enterprise)
            ->pluck('name', 'id');

        return view('sogetrel_passwork::acceptation.create', @compact('passwork', 'vendor_compliance_managers'));
    }

    public function viewOperationalMonitoringData(SogetrelPasswork $passwork, Acceptation $acceptation)
    {
        $this->authorize('create', [Acceptation::class, $passwork]);

        return view('sogetrel_passwork::acceptation.operational_monitoring_data', compact('acceptation'));
    }
}
