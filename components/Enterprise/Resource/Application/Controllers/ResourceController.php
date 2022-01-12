<?php

namespace Components\Enterprise\Resource\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Support\Facades\Repository;
use Components\Enterprise\Resource\Application\Models\Resource;
use Components\Enterprise\Resource\Application\Repositories\ResourceRepository;
use Components\Enterprise\Resource\Application\Requests\AssignResourceRequest;
use Components\Enterprise\Resource\Application\Requests\AttachResourceRequest;
use Components\Enterprise\Resource\Application\Requests\StoreResourceRequest;
use Components\Enterprise\Resource\Domain\UseCases\CreateActivityPeriod;
use Components\Enterprise\Resource\Domain\UseCases\CreateResourceForVendor;
use Components\Enterprise\Resource\Domain\UseCases\DeleteResource;
use Components\Enterprise\Resource\Domain\UseCases\ShowResource;
use Components\Enterprise\Resource\Domain\UseCases\UpdateResource;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ResourceController extends Controller
{
    protected $resourceRepository;

    public function __construct(ResourceRepository $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
    }

    public function index(Request $request, Enterprise $enterprise)
    {
        $this->authorize('index', [Resource::class, $enterprise]);

        $resource = $this->resourceRepository->make();
        $resource->enterprise()->associate($enterprise);

        $items = $this->resourceRepository
            ->list($request->input('filter'), $request->input('search'))
            ->ofVendor($enterprise)
            ->latest()
            ->paginate(25);

        return view('resource::index', compact('items', 'enterprise', 'resource'));
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('create', [Resource::class, $enterprise]);

        $resource = $this->resourceRepository->make();
        $resource->enterprise()->associate($enterprise);

        return view('resource::create', compact('enterprise', 'resource'));
    }

    public function store(Enterprise $enterprise, StoreResourceRequest $request)
    {
        $this->authorize('create', [Resource::class, $enterprise]);

        $data = $request->input();
        $data['resource']['enterprise_id'] = $enterprise->id;

        if ($request->has('resource.file')) {
            $data['resource']['file'] = $request->file('resource.file');
        }

        $resource = App::make(CreateResourceForVendor::class)->handle($data['resource']);

        if ($request->has('resource.activity_period.customer_id')) {
            App::make(CreateActivityPeriod::class)->handle(
                $resource,
                Repository::enterprise()->find($request->input('resource.activity_period.customer_id')),
                new DateTime($request->input('resource.activity_period.starts_at')),
                new DateTime($request->input('resource.activity_period.ends_at'))
            );
        }
        return $this->redirectWhen(
            $resource->exists,
            route('addworking.enterprise.resource.show', [$enterprise, $resource])
        );
    }

    public function show(Enterprise $enterprise, Resource $resource)
    {
        $this->authorize('show', $resource);

        $resource = App::make(ShowResource::class)->handle($resource->getNumber());

        return view('resource::show', compact('enterprise', 'resource'));
    }

    public function edit(Enterprise $enterprise, Resource $resource)
    {
        $this->authorize('edit', $resource);

        return view('resource::edit', compact('enterprise', 'resource'));
    }

    public function update(StoreResourceRequest $request, Enterprise $enterprise, Resource $resource)
    {
        $this->authorize('update', $resource);

        $data = $request->input();
        $data['resource']['id'] = $resource->id;

        $resource = App::make(UpdateResource::class)->handle($data['resource']);

        return $this->redirectWhen(
            $resource->exists,
            route('addworking.enterprise.resource.show', [$enterprise, $resource])
        );
    }

    public function destroy(Enterprise $enterprise, Resource $resource)
    {
        $this->authorize('destroy', $resource);

        $deleted = App::make(DeleteResource::class)->handle($resource->id);

        return $this->redirectWhen($deleted, route('addworking.enterprise.resource.index', $enterprise));
    }

    public function assign(Enterprise $enterprise, Resource $resource)
    {
        $this->authorize('assign', $resource);

        return view('resource::assign', compact('resource'));
    }

    public function assignPost(AssignResourceRequest $request, Enterprise $enterprise, Resource $resource)
    {
        $this->authorize('assign', $resource);

        $created = App::make(CreateActivityPeriod::class)->handle(
            $resource,
            Repository::enterprise()->find($request->input('activity_period.customer_id')),
            new DateTime($request->input('activity_period.starts_at')),
            new DateTime($request->input('activity_period.ends_at'))
        );

        return $this->redirectWhen($created, $resource->routes->show);
    }

    public function attach(Enterprise $enterprise, Resource $resource)
    {
        return view('resource::attach', compact('resource'));
    }

    public function attachPost(AttachResourceRequest $request, Enterprise $enterprise, Resource $resource)
    {
        $attached = $this->resourceRepository->attach($resource, $request->file('file.content'));
        return $this->redirectWhen($attached->exists, $resource->routes->show);
    }

    public function detach(Request $request, Enterprise $enterprise, Resource $resource)
    {
        $file = File::find($request->input('file_id'));

        $detached = $this->resourceRepository->detach($resource, $file);

        return $this->redirectWhen($detached, $resource->routes->show);
    }
}
