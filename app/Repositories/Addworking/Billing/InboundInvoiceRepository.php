<?php

namespace App\Repositories\Addworking\Billing;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Common\CommentRepository;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrder;
use Components\Billing\PaymentOrder\Application\Repositories\PaymentOrderItemRepository;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class InboundInvoiceRepository extends BaseRepository
{
    protected $model = InboundInvoice::class;
    protected $item;
    protected $commentRepository;

    public function __construct(InboundInvoiceItemRepository $item, CommentRepository $commentRepository)
    {
        $this->item = $item;
        $this->commentRepository = $commentRepository;
    }

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return InboundInvoice::query()
            ->when($filter['created_at'] ?? null, function ($query, $date) {
                return $query->filterCreatedAt($date);
            })
            ->when($filter['enterprise'] ?? null, function ($query, $enterprise) {
                return $query->filterEnterprise($enterprise);
            })
            ->when($filter['customer'] ?? null, function ($query, $customer) {
                return $query->filterCustomer($customer);
            })
            ->when($filter['number'] ?? null, function ($query, $number) {
                return $query->withNumber($number);
            })
            ->when($filter['status'] ?? null, function ($query, $status) {
                return $query->status($status);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function createFromRequest(Request $request, Enterprise $enterprise): InboundInvoice
    {
        return DB::transaction(function () use ($request, $enterprise) {
            $inbound_invoice = $this->fillData($request, $enterprise, $this->make());
            $this->associateFile($inbound_invoice, $enterprise, $request);
            $inbound_invoice->save();
            return $inbound_invoice;
        });
    }

    public function updateFromRequest(
        Request $request,
        Enterprise $enterprise,
        InboundInvoice $inbound_invoice
    ) {
        return DB::transaction(function () use ($request, $enterprise, $inbound_invoice) {
            return tap($inbound_invoice, function ($invoice) use ($request, $enterprise, $inbound_invoice) {
                $invoice = $this->fillData($request, $enterprise, $inbound_invoice);
                $this->associateFile($inbound_invoice, $enterprise, $request);

                if ($inbound_invoice->status == InboundInvoice::STATUS_VALIDATED) {
                    $this->comment($inbound_invoice);

                    $now = Carbon::now();
                    ActionTrackingHelper::track(
                        $request->user(),
                        ActionEntityInterface::VALIDATE_INBOUND_INVOICE,
                        $inbound_invoice,
                        __(
                            'addworking.billing.inbound_invoice.tracking.validate',
                            [
                                'user' => 'AddWorking',
                                'date' => $now->format('d/m/Y'),
                                'datetime' => $now->format('H:i'),
                            ]
                        )
                    );
                }

                return $invoice->save();
            });
        });
    }

    public function validate(InboundInvoice $inbound_invoice): bool
    {
        return $inbound_invoice->update(['status' => InboundInvoice::STATUS_VALIDATED]);
    }

    protected function fillData(Request $request, Enterprise $enterprise, InboundInvoice $inbound_invoice)
    {
        $inbound_invoice->fill($request->input('inbound_invoice'));
        $deadline = DeadlineType::find($request->input('inbound_invoice.deadline_id'));
        $inbound_invoice->due_at = $inbound_invoice->invoiced_at->addDays($deadline->value);
        $inbound_invoice->updatedBy()->associate($request->user());

        $customer = Enterprise::find($request->input('inbound_invoice.customer_id'));
        $inbound_invoice->deadline()->associate($deadline->id)
            ->enterprise()->associate($enterprise)
            ->customer()->associate($customer);

        if ($request->filled('inbound_invoice.outbound_invoice_id')) {
            $inbound_invoice->outboundInvoice()->associate($request->input('inbound_invoice.outbound_invoice_id'));
        }

        $inbound_invoice->setIsFactoring($request->input('inbound_invoice.is_factoring') ?? false);

        return $inbound_invoice;
    }

    protected function associateFile(InboundInvoice $inbound_invoice, Enterprise $enterprise, Request $request)
    {
        if ($request->hasFile('file.content')) {
            $inbound_invoice->file()->associate(
                tap(File::from($request->file('file.content')), function ($file) use ($enterprise, $request) {
                    $file->name("/{$enterprise->id}/facture-{$request->input('inbound_invoice.number')}-%ts%.%ext%")
                        ->save();
                })
            );

            $now = Carbon::now();
            if (!is_null($inbound_invoice->id)) {
                ActionTrackingHelper::track(
                    $request->user(),
                    ActionEntityInterface::REPLACE_FILE_INBOUND_INVOICE,
                    $inbound_invoice,
                    __(
                        'addworking.billing.inbound_invoice.tracking.replace_file',
                        [
                            'user' => $request->user()->isSupport() ? 'AddWorking' : $request->user()->name,
                            'date' => $now->format('d/m/Y'),
                            'datetime' => $now->format('H:i'),
                        ]
                    )
                );
            }
        }
    }

    public function comment(InboundInvoice $inbound_invoice)
    {
        $comment = "Cette facture prestataire a été validée";

        $this->commentRepository->comment($inbound_invoice, $comment, 'public');
    }

    public function updateComplianceStatusFromRequest(Request $request, InboundInvoice $inbound_invoice): bool
    {
        return $inbound_invoice->update($request->input('inbound_invoice'));
    }

    public function getPaymentOrderOfInboundInvoice(InboundInvoice $inbound_invoice)
    {
        return PaymentOrder::whereHas('items', function ($query) use ($inbound_invoice) {
            return $query->whereHas('inboundInvoice', function ($query) use ($inbound_invoice) {
                return $query->where('id', $inbound_invoice->id);
            });
        })->first();
    }
}
