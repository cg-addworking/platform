<?php

namespace App\Repositories\Addworking\Mission;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\PurchaseOrder;
use App\Notifications\Addworking\Mission\PurchaseOrderReferentNotification;
use App\Notifications\Addworking\Mission\PurchaseOrderVendorNotification;
use App\Repositories\Addworking\Common\FileRepository;
use App\Repositories\BaseRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class PurchaseOrderRepository extends BaseRepository
{
    protected $model = PurchaseOrder::class;

    protected $file;

    public function __construct(FileRepository $file)
    {
        $this->file = $file;
    }

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return PurchaseOrder::query()
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function createFromMission(Mission $mission): PurchaseOrder
    {
        return DB::transaction(function () use ($mission) {

            $file = $this->createFileFromMission($mission);

            $purchaseOrder = self::make();
            $purchaseOrder->file()->associate($file);
            $purchaseOrder->mission()->associate($mission);

            $purchaseOrder->save();

            return $purchaseOrder;
        });
    }

    public function createFileFromMission(Mission $mission) : File
    {
        return DB::transaction(function () use ($mission) {

            $pdf = PDF::loadView("addworking.mission.purchase_order.document", @compact('mission'));

            $data = [
                'path'      => sprintf('%s.%s', uniqid('/tmp/'), 'pdf'),
                'mime_type' => 'application/pdf',
                'content'   => $pdf->download()->getOriginalContent()
            ];

            $file = $this->file->make($data);

            // We check if the current user belong to the mission issuer
            // If not, that means the current user is Support() so we associate
            // the file with the first member of the  customer enterprise
            $user = $mission->customer->users()->where('id', auth()->user()->id)->exists()
                ? auth()->user()
                : $mission->customer->users()->first();

            $file->user()->associate($user);

            $file->save();

            return $file;
        });
    }

    public function setStatus(PurchaseOrder $purchaseOrder, Request $request): PurchaseOrder
    {
        return DB::transaction(function () use ($purchaseOrder, $request) {
            $purchaseOrder->update($request->input('purchase_order'));

            switch ($purchaseOrder->status) {
                case PurchaseOrder::STATUS_SENT:
                    Notification::send(
                        $purchaseOrder->mission->vendor->users,
                        new PurchaseOrderVendorNotification($purchaseOrder)
                    );
                    Notification::send(
                        $purchaseOrder->mission->offer->referent,
                        new PurchaseOrderReferentNotification($purchaseOrder)
                    );
                    break;
            }

            return $purchaseOrder;
        });
    }
}
