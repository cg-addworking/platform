<?php

namespace App\Http\Controllers\Addworking\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\PurchaseOrder;
use App\Repositories\Addworking\Mission\PurchaseOrderRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchaseOrderController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(PurchaseOrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Enterprise $enterprise, Request $request)
    {
        $this->authorize('index', [PurchaseOrder::class, $enterprise]);

        $items = $this->getPaginatorFromRequest($request, function ($query) use ($enterprise) {
            $query->whereHas('mission', function ($query) use ($enterprise) {
                $query->ofEnterprise($enterprise);
            });
        });

        return view($this->views['index']
            ?? 'addworking.mission.purchase_order.index', @compact('items', 'enterprise'));
    }

    public function create()
    {
        abort(501);
    }

    public function store(Enterprise $enterprise, Mission $mission, Request $request)
    {
        $this->authorize('create', [PurchaseOrder::class, $mission]);
        $purchaseOrder = $this->repository->createFromMission($mission);
        return redirect_when($purchaseOrder->exists, $purchaseOrder->routes->show);
    }

    public function show(Enterprise $enterprise, Mission $mission, PurchaseOrder $purchaseOrder)
    {
        $this->authorize('view', $purchaseOrder);

        return view(
            $this->views['show'] ?? 'addworking.mission.purchase_order.show',
            @compact('enterprise', 'mission', 'purchaseOrder')
        );
    }

    public function edit($id)
    {
        abort(501);
    }

    public function update(Request $request, $id)
    {
        abort(501);
    }

    public function destroy(Enterprise $enterprise, Mission $mission, PurchaseOrder $purchaseOrder)
    {
        $this->authorize('delete', $purchaseOrder);

        $deleted = $purchaseOrder->delete();

        return $deleted
            ? redirect()->route($this->redirects['destroy'] ?? 'mission.index')
                ->with(success_status("Bon de commande supprimé avec succès"))
            : back()->with(error_status());
    }

    public function send(
        Enterprise $enterprise,
        Mission $mission,
        PurchaseOrder $purchaseOrder,
        Request $request
    ) {
        $this->authorize('send', $purchaseOrder);

        $purchaseOrder = $this->repository->setStatus($purchaseOrder, $request);

        return $this->redirectWhen(
            $this->redirects['update_status'] ?? $purchaseOrder->exists,
            $purchaseOrder->routes->show
        );
    }
}
