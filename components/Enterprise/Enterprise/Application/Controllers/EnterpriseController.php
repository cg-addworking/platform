<?php

namespace Components\Enterprise\Enterprise\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\Enterprise\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\Enterprise\Application\Repositories\UserRepository;
use Components\Enterprise\Enterprise\Domain\UseCases\ListEnterprisesAsSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class EnterpriseController extends Controller
{
    private $enterpriseRepository;
    private $userRepository;

    public function __construct(
        EnterpriseRepository $enterpriseRepository,
        UserRepository $userRepository
    ) {
        $this->enterpriseRepository = $enterpriseRepository;
        $this->userRepository = $userRepository;
    }

    public function indexSupport(Request $request)
    {
        $this->authorize('indexSupport', Enterprise::class);

        $items = App::make(ListEnterprisesAsSupport::class)
            ->handle(
                Auth::user(),
                $request->input('filter'),
                $request->input('search'),
                $request->input('per-page'),
                $request->input('operator'),
                $request->input('field')
            );

        $searchable_attributes = $this->enterpriseRepository->getSearchableAttributes();

        return view('enterprise::enterprise.indexSupport', compact('items', 'searchable_attributes'));
    }
}
