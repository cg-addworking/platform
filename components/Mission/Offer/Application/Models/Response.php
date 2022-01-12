<?php

namespace Components\Mission\Offer\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\Concerns\Comment\Commentable;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Application\Models\Scopes\ResponseScope;
use Components\Mission\Offer\Application\Models\Scopes\SearchScope;
use Components\Mission\Offer\Domain\Interfaces\Entities\ResponseEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Response extends Model implements ResponseEntityInterface
{
    use SoftDeletes, HasUuid, Commentable, ResponseScope, SearchScope;

    protected $table = 'addworking_mission_proposal_responses';

    protected $fillable = [
        'starts_at',
        'ends_at',
        'amount_before_taxes',
        'argument',
        'status',
        'number',
    ];

    protected $dates = [
        'starts_at',
        'ends_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'amount_before_taxes' => 'float',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------
    
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id')->withDefault();
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id')->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id')->withDefault();
    }

    // ------------------------------------------------------------------------
    // Setters
    // ------------------------------------------------------------------------

    public function setStartsAt($value): void
    {
        $this->starts_at = $value;
    }

    public function setEndsAt($value): void
    {
        $this->ends_at = $value;
    }

    public function setAmountBeforeTaxes($value): void
    {
        $this->amount_before_taxes = $value;
    }

    public function setArgument($value): void
    {
        $this->argument = $value;
    }

    public function setStatus($value): void
    {
        $this->status = $value;
    }

    public function setNumber(): void
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setOffer($value): void
    {
        $this->offer()->associate($value);
    }

    public function setCreatedBy($value): void
    {
        $this->createdBy()->associate($value);
    }

    public function setFile($value): void
    {
        $this->file()->associate($value);
    }

    public function setEnterprise($value): void
    {
        $this->enterprise()->associate($value);
    }

    // ------------------------------------------------------------------------
    // Getters
    // ------------------------------------------------------------------------
    
    public function getStatus(): string
    {
        return $this->status;
    }

    public function getArgument()
    {
        return $this->argument;
    }

    public function getStartsAt()
    {
        return $this->starts_at;
    }

    public function getEndsAt()
    {
        return $this->ends_at;
    }

    public function getCreatedBy()
    {
        return $this->createdBy()->first();
    }

    public function getOffer()
    {
        return $this->offer()->first();
    }

    public function getEnterprise()
    {
        return $this->enterprise()->first();
    }

    public function getFile()
    {
        return $this->file()->first();
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getAmountBeforeTaxes(): float
    {
        return $this->amount_before_taxes;
    }
}
