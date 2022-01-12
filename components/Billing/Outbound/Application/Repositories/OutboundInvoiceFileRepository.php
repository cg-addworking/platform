<?php
namespace Components\Billing\Outbound\Application\Repositories;

use App\Models\Addworking\Billing\VatRate;
use App\Models\Addworking\Common\File;
use Barryvdh\DomPDF\Facade as PDF;
use Components\Billing\Outbound\Application\Models\Fee;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceFileRepositoryInterface;
use Illuminate\Support\Arr;

class OutboundInvoiceFileRepository implements OutboundInvoiceFileRepositoryInterface
{
    private $outboundInvoiceRepository;
    private $outboundInvoiceItemRepository;
    private $feeRepository;
    private $enterpriseRepository;

    public function __construct()
    {
        $this->outboundInvoiceRepository     = new OutboundInvoiceRepository();
        $this->outboundInvoiceItemRepository = new OutboundInvoiceItemRepository();
        $this->feeRepository                 = new FeeRepository();
        $this->enterpriseRepository          = new EnterpriseRepository();
    }

    public function generate(OutboundInvoiceInterface $outboundInvoice, $address)
    {
        $linesAnnex = $this->getItemsLines($outboundInvoice);
        $linesAddhoc = $this->getAddhocLines($outboundInvoice);
        $lines = $this->getLinesGroupedByVendor($outboundInvoice);
        $subscriptionLines = $this->getSubscriptionFees($outboundInvoice);
        $fixedFeesLines = $this->getFixedFees($outboundInvoice);
        $subTotalOfTaxes = $this->getSubTotalOfTaxes($outboundInvoice);


        $pdf = PDF::loadView(
            "outbound_invoice::file.document",
            @compact(
                'outboundInvoice',
                'address',
                'lines',
                'subscriptionLines',
                'fixedFeesLines',
                'linesAnnex',
                'linesAddhoc',
                'subTotalOfTaxes'
            )
        );

        $file = File::from($pdf->output())
            ->fill(['mime_type' => "application/pdf"])
            ->name("/{$outboundInvoice->getId()}/facture-addworking-{$outboundInvoice->getFormattedNumber()}-%ts%.pdf")
            ->saveAndGet();

        $outboundInvoice->setFile($file);

        return $this->outboundInvoiceRepository->hasFile($outboundInvoice);
    }

    public function getAddhocLines(OutboundInvoiceInterface $outboundInvoice)
    {
        $addhoc = OutboundInvoiceItem::doesntHave('vendor')
        ->whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
            $query->where('id', $outboundInvoice->getId());
        })->cursor();

        $lines = [];

        foreach ($addhoc as $item) {
            $lines[] = [
                'vendor_code' => 'n/a',
                'vendor_name' => $item->getLabel() ?? 'n/a',
                'period'      => $outboundInvoice->getMonth(),
                'amount'      => $item->getAmountBeforeTaxes(),
            ];
        }

        return $lines;
    }

    public function getLinesGroupedByVendor(OutboundInvoiceInterface $outboundInvoice)
    {
        $lines = [];
        
        $vendors = OutboundInvoiceItem::has('vendor')
        ->whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
            $query->where('id', $outboundInvoice->getId());
        })->cursor()->groupBy('vendor_id');

        foreach ($vendors as $id => $items) {
            $amount = round($items->reduce(function ($carry, OutboundInvoiceItem $item) use ($outboundInvoice) {
                return $carry
                    + $item->getAmountBeforeTaxes()
                    + $this->feeRepository->getManagementFeesOfOutboundInvoiceItemBeforeTaxes($item, $outboundInvoice);
            }, 0), 2);

            // TODO : Change this with code vendor in has_partners pivot
            $vendorCode = $this->enterpriseRepository->find($id)->sogetrelData->navibat_id ?? "n/a";

            $lines[$id] = [
                'vendor_code' => $vendorCode,
                'vendor_name' => $this->enterpriseRepository->find($id)->name ?? 'n/a',
                'period'      => $outboundInvoice->getMonth(),
                'amount'      => $amount,
            ];
        }

        return Arr::sort($lines, function ($value) {
            return $value['vendor_name'];
        });
    }

    public function getItemsLines(OutboundInvoiceInterface $outboundInvoice)
    {
        return OutboundInvoiceItem::whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
            $query->where('id', $outboundInvoice->getId());
        })->with(['fees' => function ($query) {
            $query->whereIn('type', [Fee::DEFAULT_MANAGMENT_FEES_TYPE, Fee::CUSTOM_MANAGMENT_FEES_TYPE]);
        }])->orderBy('vendor_id')->cursor();
    }

    public function getFees(OutboundInvoiceInterface $outboundInvoice)
    {
        return Fee::whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
            $query->where('id', $outboundInvoice->getId());
        })->cursor();
    }

    public function getSubscriptionFees(OutboundInvoiceInterface $outboundInvoice)
    {
        return Fee::where('type', Fee::SUBSCRIPTION_TYPE)
            ->whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
                $query->where('id', $outboundInvoice->getId());
            })->cursor();
    }

    public function getDiscountFees(OutboundInvoiceInterface $outboundInvoice)
    {
        return Fee::where('type', Fee::DISCOUNT_TYPE)
            ->whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
                $query->where('id', $outboundInvoice->getId());
            })->cursor();
    }

    public function getFixedFees(OutboundInvoiceInterface $outboundInvoice)
    {
        return Fee::where('type', Fee::FIXED_FEES_TYPE)
            ->whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
                $query->where('id', $outboundInvoice->getId());
            })->cursor();
    }

    public function getTotalOfItemsLinesBeforeTaxes(OutboundInvoiceInterface $outboundInvoice): float
    {
        $items = $this->getItemsLines($outboundInvoice);

        return round($items->reduce(function ($carry, OutboundInvoiceItem $item) {
            return $carry + $item->getAmountBeforeTaxes();
        }, 0), 2);
    }

    public function getTotalOfSubscriptionFeesBeforeTaxes(OutboundInvoiceInterface $outboundInvoice): float
    {
        $fees = $this->getSubscriptionFees($outboundInvoice);

        return round($fees->reduce(function ($carry, Fee $fee) {
            return $carry + $fee->getAmountBeforeTaxes();
        }, 0), 2);
    }

    public function getTotalOfDiscountFeesBeforeTaxes(OutboundInvoiceInterface $outboundInvoice): float
    {
        $fees = $this->getDiscountFees($outboundInvoice);

        return round($fees->reduce(function ($carry, Fee $fee) {
            return $carry + $fee->getAmountBeforeTaxes();
        }, 0), 2);
    }

    public function getTotalOfFixedFeesBeforeTaxes(OutboundInvoiceInterface $outboundInvoice): float
    {
        $fees = $this->getFixedFees($outboundInvoice);

        return round($fees->reduce(function ($carry, Fee $fee) {
            return $carry + $fee->getAmountBeforeTaxes();
        }, 0), 2);
    }

    public function getTotalLinesBeforeTaxes(OutboundInvoiceInterface $outboundInvoice): float
    {
        return $this->getTotalOfItemsLinesBeforeTaxes($outboundInvoice)
            + $this->getTotalOfSubscriptionFeesBeforeTaxes($outboundInvoice)
            + $this->getTotalOfFixedFeesBeforeTaxes($outboundInvoice);
    }

    public function getSubTotalOfTaxes(OutboundInvoiceInterface $outbound_invoice): array
    {
        $vatRates = VatRate::all();
        $subtotal = [];

        foreach ($vatRates as $vatRate) {
            $total = 0;
            foreach ($this->getItemsLines($outbound_invoice) as $line) {
                if ($line->getVatRate()->id == $vatRate->id) {
                    $total += $line->getAmountOfTaxes();
                }
            }
            foreach ($this->getFees($outbound_invoice) as $line) {
                if ($line->getVatRate()->id == $vatRate->id) {
                    $total += $line->getAmountOfTaxes();
                }
            }
            $subtotal += [$vatRate->id => round($total, 2)];
        }
        
        return $subtotal;
    }
}
