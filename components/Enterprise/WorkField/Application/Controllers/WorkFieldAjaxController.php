<?php

namespace Components\Enterprise\WorkField\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Enterprise\WorkField\Application\Repositories\UserRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository;
use Components\Enterprise\WorkField\Domain\UseCases\AttachContributorToWorkField;
use Components\Enterprise\WorkField\Domain\UseCases\DetachContributorToWorkField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class WorkFieldAjaxController extends Controller
{
    protected $userRepository;
    protected $workFieldRepository;
    protected $workFieldContributorRepository;

    public function __construct(
        UserRepository $userRepository,
        WorkFieldRepository $workFieldRepository,
        WorkFieldContributorRepository $workFieldContributorRepository
    ) {
        $this->userRepository = $userRepository;
        $this->workFieldRepository = $workFieldRepository;
        $this->workFieldContributorRepository = $workFieldContributorRepository;
    }


    public function getContributors(Request $request)
    {
        $request->validate([
            'enterprise' => 'required|uuid|exists:addworking_enterprise_enterprises,id'
        ]);

        if ($request->ajax()) {
            $enterprise = Enterprise::where('id', $request->input('enterprise'))->first();

            $contributors = $enterprise->users()->get()->pluck('name', 'id');

            $response = [
                'status' => 200,
                'data' => $contributors,
            ];

            return response()->json($response);
        }

        abort(501);
    }

    public function getContributorsWithoutCreator(Request $request)
    {
        $request->validate([
            'enterprise' => 'required|uuid|exists:addworking_enterprise_enterprises,id'
        ]);

        if ($request->ajax()) {
            $enterprise = Enterprise::where('id', $request->input('enterprise'))->first();

            $contributors = $enterprise->users()->where('id', '!=', $request->user()->id)->get()->pluck('name', 'id');

            $response = [
                'status' => 200,
                'data' => $contributors,
            ];

            return response()->json($response);
        }

        abort(501);
    }

    public function detachContributor(Request $request)
    {
        $request->validate(['id' => 'required|uuid|exists:addworking_enterprise_work_field_has_contributors,id']);

        if ($request->ajax()) {
            $authenticated = $this->userRepository->connectedUser();
            $work_field_contributor = $this->workFieldContributorRepository->find($request->input('id'));

            $detached = App::make(DetachContributorToWorkField::class)->handle($authenticated, $work_field_contributor);

            if ($detached) {
                $response = ['status' => 200, 'message' => "Suppression effectuée avec succes"];
            } else {
                $response = ['status' => 400, 'message' => "Erreur lors de la suppression"];
            }

            return response()->json($response);
        }

        abort(501);
    }

    public function setAdministrator(Request $request, WorkField $work_field)
    {
        $this->authorize('manageContributors', $work_field);

        $request->validate(['id' => 'required|uuid|exists:addworking_enterprise_work_field_has_contributors,id']);

        if ($request->ajax()) {
            $work_field_contributor = $this->workFieldContributorRepository->find($request->input('id'));

            if ($work_field_contributor->getIsAdmin()) {
                $work_field_contributor->setIsAdmin(false);
            } else {
                $work_field_contributor->setIsAdmin(true);
            }

            $saved = $this->workFieldContributorRepository->save($work_field_contributor);

            if ($saved) {
                $response = ['status' => 200, 'message' => "Intervenant mis à jour"];
            } else {
                $response = ['status' => 400, 'message' => "Erreur lors de la mise à jour"];
            }

            return response()->json($response);
        }

        abort(501);
    }

    public function setContractValidator(Request $request, WorkField $work_field)
    {
        $this->authorize('manageContributors', $work_field);

        $request->validate(['id' => 'required|uuid|exists:addworking_enterprise_work_field_has_contributors,id']);

        if ($request->ajax()) {
            $order = 0;
            $work_field_contributor = $this->workFieldContributorRepository->find($request->input('id'));

            if ($work_field_contributor->getIsContractValidator()) {
                $work_field_contributor->setIsContractValidator(false);
                $work_field_contributor->setContractValidationOrder(0);
            } else {
                $work_field_contributor->setIsContractValidator(true);
                $order = $this->workFieldRepository->getMaxOrderofValidatorContributor($work_field) + 1;
                $work_field_contributor->setContractValidationOrder($order);
            }

            $saved = $this->workFieldContributorRepository->save($work_field_contributor);

            if ($saved) {
                $response = ['status' => 200, 'message' => "Intervenant mis à jour", 'order' => $order];
            } else {
                $response = ['status' => 400, 'message' => "Erreur lors de la mise à jour"];
            }

            return response()->json($response);
        }

        abort(501);
    }

    public function setContractValidationOrder(Request $request, WorkField $work_field)
    {
        $this->authorize('manageContributors', $work_field);

        $request->validate(
            [
                'id' => 'required|uuid|exists:addworking_enterprise_work_field_has_contributors,id',
                'order' => 'required|min:0|numeric'
            ]
        );

        if ($request->ajax()) {
            $work_field_contributor = $this->workFieldContributorRepository->find($request->input('id'));

            $work_field_contributor->setContractValidationOrder($request->input('order'));

            $saved = $this->workFieldContributorRepository->save($work_field_contributor);

            if ($saved) {
                $response = ['status' => 200, 'message' => "Intervenant mis à jour"];
            } else {
                $response = ['status' => 400, 'message' => "Erreur lors de la mise à jour"];
            }

            return response()->json($response);
        }

        abort(501);
    }

    public function attachContributor(Request $request)
    {
        $request->validate([
            'work_field_id'  => 'required|uuid|exists:addworking_enterprise_work_fields,id',
            'contributor_id' => 'required|uuid|exists:addworking_user_users,id',
            'enterprise_id'  => 'required|uuid|exists:addworking_enterprise_enterprises,id',
        ]);

        if ($request->ajax()) {
            $authenticated = $this->userRepository->connectedUser();
            $work_field = $this->workFieldRepository->find($request->input('work_field_id'));
            $contributor = [
                'enterprise_id' => $request->input('enterprise_id'),
                'contributor_id' => $request->input('contributor_id'),
                'role' => null,
            ];

            $attached = App::make(AttachContributorToWorkField::class)->handle(
                $authenticated,
                $work_field,
                $contributor
            );

            if ($attached) {
                $response = [
                    'status' => 200,
                    'message' => "Ajout effectué avec succes",
                    'work_field_contributor_id' => $attached->getId()
                ];
            } else {
                $response = ['status' => 400, 'message' => "Erreur lors de l'ajout"];
            }

            return response()->json($response);
        }

        abort(501);
    }

    public function setRole(Request $request)
    {
        $request->validate(['id' => 'required|uuid|exists:addworking_enterprise_work_field_has_contributors,id']);

        if ($request->ajax()) {
            $work_field_contributor = $this->workFieldContributorRepository->find($request->input('id'));

            $work_field_contributor->setRole($request->input('role'));

            $saved = $this->workFieldContributorRepository->save($work_field_contributor);

            if ($saved) {
                $response = ['status' => 200, 'message' => "Intervenant mis à jour"];
            } else {
                $response = ['status' => 400, 'message' => "Erreur lors de la mise à jour"];
            }

            return response()->json($response);
        }

        abort(501);
    }
}
