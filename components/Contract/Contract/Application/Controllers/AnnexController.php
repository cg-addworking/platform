<?php

namespace Components\Contract\Contract\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Contract\Application\Models\Annex;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractPart;
use Components\Contract\Contract\Domain\Interfaces\Repositories\AnnexRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Contract\Contract\Domain\UseCases\CreateAnnex;
use Components\Contract\Contract\Domain\UseCases\DeleteAnnex;
use Components\Contract\Contract\Domain\UseCases\ListAnnexAsSupport;
use Components\Contract\Contract\Domain\UseCases\ShowAnnex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AnnexController extends Controller
{
    private $userRepository;
    private $annexRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AnnexRepositoryInterface $annexRepository
    ) {
        $this->userRepository = $userRepository;
        $this->annexRepository = $annexRepository;
    }

    public function create(Request $request)
    {
        $this->authorize('create', Annex::class);

        $annex = $this->annexRepository->make();

        return view(
            'contract::annex.create',
            compact('annex')
        );
    }

    public function store(Request $request)
    {
        $this->authorize('create', Annex::class);

        $user = $this->userRepository->connectedUser();

        $enterprise = Enterprise::find($request->input('annex.enterprise'));

        $annex = App::make(CreateAnnex::class)->handle(
            $user,
            $enterprise,
            $request->file('annex.file'),
            $request->input('annex')
        );

        return $this->redirectWhen($annex->exists, route('support.annex.index'));
    }

    public function delete(Annex $annex)
    {
        $this->authorize('delete', Annex::class);

        $user = $this->userRepository->connectedUser();

        $deleted = App::make(DeleteAnnex::class)->handle($user, $annex);

        return $this->redirectWhen($deleted, route('support.annex.index'));
    }

    public function ajaxGetEnterprises(Request $request)
    {
        if ($request->ajax()) {
            $this->authorize('create', Annex::class);

            $enterprises = Enterprise::all()->pluck('name', 'id');

            $response = [
                'status' => 200,
                'data' => $enterprises,
            ];

            return response()->json($response);
        }
        abort(501);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function indexSupport(Request $request)
    {
        $this->authorize('indexSupport', Annex::class);

        $user = $this->userRepository->connectedUser();

        $items = App::make(ListAnnexAsSupport::class)
            ->handle(
                $user,
                $request->input('filter'),
                $request->input('search'),
                $request->input('per-page'),
                $request->input('operator'),
                $request->input('field'),
            );

        return view('contract::annex.index', compact('items'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getEnterprisesWithAnnexAjax(Request $request)
    {
        $this->authorize('indexSupport', Annex::class);

        $user = $this->userRepository->connectedUser();

        $enterprises = [];

        if ($request->ajax()) {
            if ($this->userRepository->isSupport($user)) {
                $enterprises = Enterprise::whereHas('annexes')
                    ->select('id', 'name')
                    ->orderBy('name', 'ASC')
                    ->pluck('name', 'id');
            }

            return response()->json([
                'status' => 200,
                'data' => $enterprises,
            ]);
        }

        abort(501);
    }

    /**
     * @param Annex $annex
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Annex $annex)
    {
        $this->authorize('show', $annex);

        $authenticated = $this->userRepository->connectedUser();

        $annex = App::make(ShowAnnex::class)->handle($authenticated, $annex);

        return view('contract::annex.show', compact('annex'));
    }

    public function ajaxGetAvailableAnnexes(Request $request, Contract $contract)
    {
        $this->authorize('store', [ContractPart::class, $contract]);

        if ($request->ajax()) {
            $user = $this->userRepository->connectedUser();
            if ($this->userRepository->isSupport($user)) {
                $available_annexes = App::make(ListAnnexAsSupport::class)->handle($user)
                    ->pluck('display_name', 'id');
            } else {
                $available_annexes = $this
                    ->annexRepository
                    ->list(
                        $contract->getEnterprise()
                    )->pluck('display_name', 'id');
            }

            return response()->json([
                'status' => 200,
                'data' => $available_annexes,
            ]);
        }

        abort(501);
    }
}
