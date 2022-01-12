<?php

namespace Components\Enterprise\WorkField\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Common\Department;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Enterprise\WorkField\Application\Presenters\WorkFieldListPresenter;
use Components\Enterprise\WorkField\Application\Presenters\WorkFieldShowPresenter;
use Components\Enterprise\WorkField\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\WorkField\Application\Repositories\UserRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository;
use Components\Enterprise\WorkField\Application\Requests\StoreWorkFieldRequest;
use Components\Enterprise\WorkField\Application\Requests\UpdateWorkFieldRequest;
use Components\Enterprise\WorkField\Domain\UseCases\ArchiveWorkField;
use Components\Enterprise\WorkField\Domain\UseCases\AttachContributorToWorkField;
use Components\Enterprise\WorkField\Domain\UseCases\CreateWorkField;
use Components\Enterprise\WorkField\Domain\UseCases\DeleteWorkField;
use Components\Enterprise\WorkField\Domain\UseCases\DetachContributorToWorkField;
use Components\Enterprise\WorkField\Domain\UseCases\EditWorkField;
use Components\Enterprise\WorkField\Domain\UseCases\ListWorkField;
use Components\Enterprise\WorkField\Domain\UseCases\ShowWorkField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class WorkFieldController extends Controller
{
    protected $enterpriseRepository;
    protected $userRepository;
    protected $workFieldRepository;

    public function __construct(
        EnterpriseRepository $enterpriseRepository,
        UserRepository $userRepository,
        WorkFieldRepository $workFieldRepository
    ) {
        $this->enterpriseRepository = $enterpriseRepository;
        $this->userRepository = $userRepository;
        $this->workFieldRepository = $workFieldRepository;
    }

    public function create(Request $request)
    {
        $this->authorize('create', WorkField::class);

        $work_field = $this->workFieldRepository->make();

        $authenticated_enterprise = $this->userRepository->connectedUser()->enterprise;
        $subsidiaries = $this->enterpriseRepository->getOwnerAndDescendants($authenticated_enterprise)->sortBy('name');
        $departments = Department::orderBy('insee_code', 'asc')->cursor()->pluck('name', 'id');

        return view(
            'work_field::work_field.create',
            compact(
                'subsidiaries',
                'work_field',
                'departments'
            )
        );
    }

    public function store(StoreWorkFieldRequest $request)
    {
        $this->authorize('create', WorkField::class);

        $authenticated = $this->userRepository->connectedUser();

        $work_field = App::make(CreateWorkField::class)->handle(
            $authenticated,
            $authenticated->enterprise,
            $request->input('work_field')
        );

        $contributors = $request->has('contributors') ? $request->input('contributors') : [];
        $contributors = $contributors + [
            $authenticated->id => [
                'is_admin' => true,
                'role' => null,
                'contributor_id' => $authenticated->id,
                'enterprise_id' => $authenticated->enterprise->id,
            ]
        ];

        foreach ($contributors as $contributor) {
            App::make(AttachContributorToWorkField::class)->handle(
                $authenticated,
                $work_field,
                $contributor
            );
        }

        return $this->redirectWhen($work_field->exists, route('work_field.show', $work_field));
    }

    public function edit(WorkField $work_field)
    {
        $this->authorize('edit', $work_field);
        $departments = Department::orderBy('insee_code', 'asc')->cursor()->pluck('name', 'id');
        $selected_departments = $work_field->getDepartments()->pluck('id')->toArray();

        return view(
            'work_field::work_field.edit',
            compact(
                'work_field',
                'departments',
                'selected_departments'
            )
        );
    }

    public function update(UpdateWorkFieldRequest $request, WorkField $work_field)
    {
        $this->authorize('edit', $work_field);

        $work_field = App::make(EditWorkField::class)->handle(
            $this->userRepository->connectedUser(),
            $work_field,
            $request->input('work_field')
        );
        
        return $this->redirectWhen($work_field->exists, route('work_field.show', $work_field));
    }

    public function show(WorkField $work_field)
    {
        $this->authorize('show', $work_field);

        $presenter = new WorkFieldShowPresenter;

        $data = App::make(ShowWorkField::class)
            ->handle($presenter, $this->userRepository->connectedUser(), $work_field);

        return view('work_field::work_field.show', ['data' => $data]);
    }

    public function delete(WorkField $work_field)
    {
        $this->authorize('delete', $work_field);

        foreach ($work_field->getWorkFieldContributors() as $work_field_contributor) {
            App::make(DetachContributorToWorkField::class)
                ->handle($this->userRepository->connectedUser(), $work_field_contributor);
        }

        $deleted = App::make(DeleteWorkField::class)
            ->handle($this->userRepository->connectedUser(), $work_field);

        return $this->redirectWhen($deleted, route('work_field.index'));
    }

    public function index(Request $request)
    {
        $this->authorize('index', WorkField::class);

        $presenter = new WorkFieldListPresenter;

        $items = App::make(ListWorkField::class)
            ->handle(
                $presenter,
                $this->userRepository->connectedUser(),
                $request->input('filter'),
                $request->input('search'),
                $request->input('per-page'),
                $request->input('operator'),
                $request->input('field')
            );

        $searchable_attributes = $this->workFieldRepository->getSearchableAttributes();

        return view(
            'work_field::work_field.index',
            ['items' => $items,'searchable_attributes' => $searchable_attributes]
        );
    }

    public function archive(WorkField $work_field)
    {
        $this->authorize('archive', $work_field);

        $archived = App::make(ArchiveWorkField::class)
            ->handle($this->userRepository->connectedUser(), $work_field);

        return $this->redirectWhen($archived, route('work_field.index'));
    }
}
