<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Enterprise\Site\StoreSiteRequest;
use App\Http\Requests\Addworking\Enterprise\Site\UpdateSiteRequest;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Site;
use App\Repositories\Addworking\Enterprise\SiteRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(SiteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, Enterprise $enterprise)
    {
        $this->authorize('index', Site::class);

        $site = $this->repository->factory()->enterprise()->associate($enterprise);

        $items = $this->getPaginatorFromRequest($request, function ($query) {
            $query->with('phoneNumbers');
        });

        return view('addworking.enterprise.site.index', @compact('enterprise', 'items', 'site'));
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('create', Site::class);

        $site = $this->repository->factory()->enterprise()->associate($enterprise);

        return view('addworking.enterprise.site.create', @compact('enterprise', 'site'));
    }

    public function store(StoreSiteRequest $request, Enterprise $enterprise)
    {
        $this->authorize('store', Site::class);

        $site = $this->repository->createFromRequest($request, $enterprise);

        return redirect_when($site->exists, $site->routes->show);
    }

    public function show(Enterprise $enterprise, Site $site)
    {
        $this->authorize('show', $site);

        return view('addworking.enterprise.site.show', @compact('enterprise', 'site'));
    }

    public function edit(Enterprise $enterprise, Site $site)
    {
        $this->authorize('edit', $site);

        return view('addworking.enterprise.site.edit', @compact('enterprise', 'site'));
    }

    public function update(UpdateSiteRequest $request, Enterprise $enterprise, Site $site)
    {
        $this->authorize('update', $site);

        $site = $this->repository->updateFromRequest($request, $enterprise, $site);

        return redirect_when($site->exists, $site->routes->show);
    }

    public function destroy(Enterprise $enterprise, Site $site)
    {
        $this->authorize('destroy', $site);

        $deleted = $site->delete();

        return redirect_when($deleted, $enterprise->routes->show)
            ->with(success_status(__('enterprise.site.delete_ok')));
    }
}
