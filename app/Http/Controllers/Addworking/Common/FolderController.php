<?php

namespace App\Http\Controllers\Addworking\Common;

use Components\Infrastructure\DatabaseCommands\Helpers\ModelFinder;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Common\Folder\LinkFolderRequest;
use App\Http\Requests\Addworking\Common\Folder\StoreFolderRequest;
use App\Http\Requests\Addworking\Common\Folder\UnlinkFolderRequest;
use App\Http\Requests\Addworking\Common\Folder\UpdateFolderRequest;
use App\Models\Addworking\Common\Folder;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Common\FolderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class FolderController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(FolderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, Enterprise $enterprise)
    {
        $this->authorize('viewAny', [Folder::class, $enterprise]);

        $items = $this->getPaginatorFromRequest($request, function ($query) use ($enterprise) {
            $query->ofEnterprise($enterprise);
        });

        $customerItems = $this->getPaginatorFromRequest($request, function ($query) use ($enterprise) {
            $query->ofCustomerEnterprises($enterprise);
        });

        return view('addworking.common.folder.index', compact('enterprise', 'items', 'customerItems'));
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('create', [Folder::class, $enterprise]);

        $folder = tap($this->repository->make(), function ($folder) use ($enterprise) {
            $folder->enterprise()->associate($enterprise);
        });

        return view('addworking.common.folder.create', compact('enterprise', 'folder'));
    }

    public function store(StoreFolderRequest $request, Enterprise $enterprise)
    {
        $this->authorize('create', [Folder::class, $enterprise]);

        $folder = $this->repository->createFromRequest($request);

        return $this->redirectWhen($folder->exists, $folder->routes->show);
    }

    public function show(Enterprise $enterprise, Folder $folder)
    {
        $this->authorize('view', $folder);

        return view('addworking.common.folder.show', compact('enterprise', 'folder'));
    }

    public function edit(Enterprise $enterprise, Folder $folder)
    {
        $this->authorize('update', $folder);

        return view('addworking.common.folder.edit', compact('enterprise', 'folder'));
    }

    public function update(UpdateFolderRequest $request, Enterprise $enterprise, Folder $folder)
    {
        $this->authorize('update', $folder);

        $folder = $this->repository->updateFromRequest($request, $folder);

        return $this->redirectWhen($folder->exists, $folder->routes->show);
    }

    public function destroy(Enterprise $enterprise, Folder $folder)
    {
        $this->authorize('delete', $folder);

        $deleted = $this->repository->delete($folder);

        return $this->redirectWhen($deleted, $folder->routes->index);
    }

    public function attach(Request $request, Enterprise $enterprise)
    {
        $item = App::make('laravel-models')->find($request->get('id'));

        $this->authorize('attach', [Folder::class, $enterprise, $item]);

        $folders = $enterprise->folders()->orderBy('display_name')->get();

        return view('addworking.common.folder.attach', compact('enterprise', 'item', 'folders'));
    }

    public function link(LinkFolderRequest $request, Enterprise $enterprise)
    {
        $folder = $this->repository->find($request->input('folder.id'));
        $item   = App::make('laravel-models')->find($request->input('item.id'));

        $this->authorize('link', [$folder, $item]);

        $verificationDouble = DB::table('addworking_common_folders_has_items')
            ->where('folder_id', $folder->id)
            ->where('item_id', $item->id)
            ->first();

        if (is_null($verificationDouble)) {
            $folder->link($item);
        }

        return redirect(isset($item->routes->show) ? $item->routes->show : $folder->routes->show);
    }

    public function unlink(UnlinkFolderRequest $request, Enterprise $enterprise)
    {
        $folder = $this->repository->find($request->input('folder.id'));
        $item   = App::make('laravel-models')->find($request->input('item.id'));

        $this->authorize('unlink', [$folder, $item]);

        $linked = $folder->unlink($item);

        return $this->redirectWhen($linked, isset($item->routes->show) ? $item->routes->show : $folder->routes->show);
    }
}
