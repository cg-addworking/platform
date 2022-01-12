<?php

namespace Components\Sogetrel\Mission\Application\Models;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Mission\MissionTrackingLine;
use Components\Common\Common\Domain\Interfaces\FileImmutableInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingLineEntityInterface;
use Components\Sogetrel\Mission\Application\Models\Scopes\SearchScope;
use Components\Sogetrel\Mission\Domain\Interfaces\MissionTrackingLineAttachmentEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MissionTrackingLineAttachment extends Model implements MissionTrackingLineAttachmentEntityInterface
{
    use HasUuid, Routable, Viewable, SearchScope;

    protected $table = "sogetrel_mission_mission_tracking_line_attachments";

    protected $routePrefix = "sogetrel.mission.mission_tracking_line_attachment";

    protected $viewPrefix = "sogetrel_mission::mission_tracking_line_attachment";

    protected $fillable = [
        'amount',
        'num_order',
        'num_attachment',
        'num_site',
        'signed_at',
        'submitted_at',
        'reverse_charges', // autoliquidation
        'direct_billing', // facturation directe
        'created_from_airtable',
    ];

    protected $dates = [
        'signed_at',
        'submitted_at',
    ];

    protected $casts = [
        'amount' => "float",
        'reverse_charges' => "bool",
        'direct_billing' => "bool",
        'created_from_airtable' => 'bool',
    ];

    protected $attributes = [
        'created_from_airtable' => false,
    ];

    protected $routeParameterAliases = [
        'line' => "missionTrackingLine",
        'tracking' => "missionTracking",
    ];

    public function __toString()
    {
        return substr($this->id, 0, 8);
    }

    public function missionTrackingLine()
    {
        return $this->belongsTo(MissionTrackingLine::class)->withDefault();
    }

    public function file()
    {
        return $this->belongsTo(File::class)->withDefault();
    }

    // ------------------------------------------------------------------------
    // Interface methods
    // ------------------------------------------------------------------------

    public function getId(): string
    {
        if (! $this->exists) {
            throw new \RuntimeException("this attachment doesn't exists");
        }

        return $this->id;
    }

    public function getTrackingLine(): TrackingLineEntityInterface
    {
        $line = $this->missionTrackingLine;

        if (! $line->exists) {
            throw new \RuntimeException("no tracking line is currently associated to this attachment");
        }

        return $line;
    }

    public function setTrackingLine(TrackingLineEntityInterface $line): self
    {
        $this->missionTrackingLine()->associate($line->getId());

        return $this;
    }

    public function getFile(): FileImmutableInterface
    {
        $file = $this->file;

        if (! $file->exists) {
            throw new \RuntimeException("no file is currently associated to this attachment");
        }

        return $file;
    }

    public function setFile(FileImmutableInterface $file): self
    {
        $this->file()->associate($file->getId());

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSignedAt(): \DateTime
    {
        return $this->signed_at;
    }

    public function setSignedAt(\DateTime $signed_at): self
    {
        $this->signed_at = $signed_at;

        return $this;
    }

    public function getSubmittedAt(): ?\DateTime
    {
        return $this->submitted_at;
    }

    public function setSubmittedAt(?\DateTime $submitted_at): self
    {
        $this->submitted_at = $submitted_at;

        return $this;
    }

    public function getReverseCharges(): bool
    {
        return $this->reverse_charges;
    }

    public function setReverseCharges(bool $reverse_charges): self
    {
        $this->reverse_charges = $reverse_charges;

        return $this;
    }

    public function getDirectBilling(): bool
    {
        return $this->direct_billing;
    }

    public function setDirectBilling(bool $direct_billing): self
    {
        $this->direct_billing = $direct_billing;

        return $this;
    }

    public function getNumAttachment(): ?string
    {
        return $this->num_attachment;
    }

    public function setNumAttachment(?string $num_attachment): self
    {
        $this->num_attachment = $num_attachment;

        return $this;
    }

    public function getNumOrder(): ?string
    {
        return $this->num_order;
    }

    public function setNumOrder(?string $num_order): self
    {
        $this->num_order = $num_order;

        return $this;
    }

    public function getNumSite(): ?string
    {
        return $this->num_site;
    }

    public function setNumSite(?string $num_site): self
    {
        $this->num_site = $num_site;

        return $this;
    }

    public function scopeFilterInboundInvoice($query, $value)
    {
        switch ($value) {
            case "yes":
                return $query->whereHas('missionTrackingLine.invoiceItems.inboundInvoice', function ($query) {
                    return $query->whereNotNull('id');
                });
                break;
            case "no":
                return $query->whereHas('missionTrackingLine', function ($query) {
                    return $query->whereDoesntHave('invoiceItems');
                });
                break;
        }
    }

    public function scopeFilterOutboundInvoice($query, $value)
    {
        switch ($value) {
            case "yes":
                return $query->whereHas(
                    'missionTrackingLine.invoiceItems.inboundInvoice.outboundInvoice',
                    function ($query) {
                        return $query->whereNotNull('id');
                    }
                );
            break;
            case "no":
                return $query->whereHas('missionTrackingLine', function ($query) {
                    return $query->whereHas('invoiceItems', function ($query) {
                        return $query->whereHas('inboundInvoice', function ($query) {
                            return $query->whereDoesntHave('outboundInvoice');
                        })->orWhereDoesntHave('inboundInvoice');
                    })->orWhereDoesntHave('invoiceItems');
                });
            break;
        }
    }

    public function scopeFilterCustomer($query, $search, $operator)
    {
        switch ($operator) {
            case "like":
                return $query->whereHas('customer', function ($query) use ($search) {
                    return $query->where(
                        DB::raw("LOWER(CAST(name as TEXT))"),
                        'LIKE',
                        "%".strtolower($search)."%"
                    );
                });
                break;
            case "equal":
                return $query->whereHas('customer', function ($query) use ($search) {
                    return $query->where(DB::raw("LOWER(CAST(name as TEXT))"), '=', strtolower($search));
                });
                break;
        }
    }

    public function scopeFilterVendor($query, $search, $operator)
    {
        switch ($operator) {
            case "like":
                $query->whereHas('vendor', function ($query) use ($search) {
                    return $query->where(
                        DB::raw("LOWER(CAST(name as TEXT))"),
                        'LIKE',
                        "%".strtolower($search)."%"
                    );
                });
                break;
            case "equal":
                $query->whereHas('vendor', function ($query) use ($search) {
                    return $query->where(DB::raw("LOWER(CAST(name as TEXT))"), '=', strtolower($search));
                });
                break;
        }
    }
}
