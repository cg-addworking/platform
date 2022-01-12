<?php

namespace Components\Sogetrel\Mission\Application\Repositories;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseCollection;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Common\Common\Domain\Interfaces\EntityInterface;
use Components\Sogetrel\Mission\Application\Models\MissionTrackingLineAttachment;
use Components\Sogetrel\Mission\Domain\Interfaces\MissionTrackingLineAttachmentEntityInterface;
use Components\Sogetrel\Mission\Domain\Interfaces\MissionTrackingLineAttachmentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MissionTrackingLineAttachmentRepository implements MissionTrackingLineAttachmentRepositoryInterface
{
    protected $enterprises;

    public function __construct(EnterpriseRepository $enterprises)
    {
        $this->enterprises = $enterprises;
    }

    public function find(string $uuid): MissionTrackingLineAttachmentEntityInterface
    {
        return MissionTrackingLineAttachment::findOrFail($uuid);
    }

    public function make(): MissionTrackingLineAttachmentEntityInterface
    {
        return new MissionTrackingLineAttachment;
    }

    public function save(EntityInterface $entity): bool
    {
        if (! $entity instanceof MissionTrackingLineAttachmentEntityInterface) {
            throw new \RuntimeException("unable to save an instance of " . get_class($entity));
        }

        if ($entity instanceof Model) {
            return $entity->save();
        }

        throw new \RuntimeException("not implemented");
    }

    public function getCustomerWithVendors(): EnterpriseCollection
    {
        return $this->enterprises->list()
            ->whereIsCustomer()
            ->whereHas('vendors', function ($query) {
                return $query->whereHas('vendorMissions');
            })
            ->orderBy('name')
            ->get();
    }

    public function getVendorsHavingMissionsWith(Enterprise $customer): EnterpriseCollection
    {
        return $customer->vendors()
            ->whereHas('vendorMissions', function ($query) use ($customer) {
                $query->whereHas('customer', fn($q) => $q->whereId($customer->id));
            })
            ->orderBy('name')
            ->get();
    }

    public function getMissionsBetween(Enterprise $customer, Enterprise $vendor): Collection
    {
        return $vendor->vendorMissions()
            ->whereHas('customer', fn($q) => $q->whereId($customer->id))
            ->latest()
            ->get();
    }

    public function getInboundInvoices(MissionTrackingLineAttachment $attachment): Collection
    {
        $vendor = $attachment->missionTrackingLine->missionTracking->mission->vendor;

        return InboundInvoice::query()
            ->whereHas('enterprise', fn($q) => $q->where('id', $vendor->id))
            ->where('amount_all_taxes_included', $attachment->amount)
            ->latest()
            ->get();
    }

    public function getOutboundInvoices(MissionTrackingLineAttachment $attachment): Collection
    {
        $collection = new Collection;

        foreach ($attachment->missionTrackingLine->invoiceItems()->cursor() as $inbound_invoice_item) {
            if ($inbound_invoice_item->inboundInvoice->outboundInvoice->exists) {
                $collection->push($inbound_invoice_item->inboundInvoice->outboundInvoice);
            }

            if ($inbound_invoice_item->outboundInvoiceItem->outboundInvoice->exists) {
                $collection->push($inbound_invoice_item->outboundInvoiceItem->outboundInvoice);
            }
        }

        return $collection->sortBy('created_at')->unique('id');
    }

    public function getSearchableAttributes(): array
    {
        return [
            MissionTrackingLineAttachmentEntityInterface::SEARCHABLE_ATTRIBUTE_NUM_ATTACHMENT =>
            'components.sogetrel.mission.application.views.mission_tracking_line_attachment._table_head.num_attachment',
            MissionTrackingLineAttachmentEntityInterface::SEARCHABLE_ATTRIBUTE_CUSTOMER =>
            'components.sogetrel.mission.application.views.mission_tracking_line_attachment._table_head.customer',
            MissionTrackingLineAttachmentEntityInterface::SEARCHABLE_ATTRIBUTE_NUM_ORDER =>
            'components.sogetrel.mission.application.views.mission_tracking_line_attachment._table_head.num_order',
            MissionTrackingLineAttachmentEntityInterface::SEARCHABLE_ATTRIBUTE_VENDOR =>
            'components.sogetrel.mission.application.views.mission_tracking_line_attachment._table_head.vendor',
        ];
    }

    public function list(Request $request)
    {
        $operator = $request->input('operator');
        $field_name = $request->input('field');

        return MissionTrackingLineAttachment::query()
            ->when($request->input('search'), function ($query, $search) use ($field_name, $operator) {
                return $this->searchByFieldName($query, $search, $field_name, $operator);
            })
            ->when($request->input('has_inbound_invoice') === "yes", function ($query) use ($request) {
                return $query->filterInboundInvoice($request->input('has_inbound_invoice'));
            })
            ->when($request->input('has_inbound_invoice') === "no", function ($query) use ($request) {
                return $query->filterInboundInvoice($request->input('has_inbound_invoice'));
            })
            ->when($request->input('has_outbound_invoice') === "yes", function ($query) use ($request) {
                return $query->filterOutboundInvoice($request->input('has_outbound_invoice'));
            })
            ->when($request->input('has_outbound_invoice') === "no", function ($query) use ($request) {
                return $query->filterOutboundInvoice($request->input('has_outbound_invoice'));
            })
            ->latest()
            ->paginate($request->input('per-page', 25));
    }

    public function searchByFieldName($query, $search, $field_name, $operator)
    {
        if (in_array(
            $field_name,
            [
                MissionTrackingLineAttachmentEntityInterface::SEARCHABLE_ATTRIBUTE_CUSTOMER,
                MissionTrackingLineAttachmentEntityInterface::SEARCHABLE_ATTRIBUTE_VENDOR
            ]
        )) {
                return $query->whereHas(
                    'missionTrackingLine.missionTracking.mission',
                    function ($query) use ($search, $operator, $field_name) {
                        switch ($field_name) {
                            case 'customer_name':
                                return $query->filterCustomer($search, $operator);
                                break;
                            case 'name':
                                return $query->filterVendor($search, $operator);
                                break;
                        }
                    }
                );
        } else {
            return $query->search($search, $operator, $field_name);
        }
    }
}
