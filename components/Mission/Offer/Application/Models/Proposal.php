<?php

namespace Components\Mission\Offer\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Components\Mission\Offer\Domain\Interfaces\Entities\ProposalEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposal extends Model implements ProposalEntityInterface
{
    use SoftDeletes, HasUuid;

    protected $table = 'addworking_mission_proposals';

    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date'
    ];

    protected $fillable = [
        'number',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function vendor()
    {
        return $this->belongsTo(Enterprise::class, 'vendor_enterprise_id')->withDefault();
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'mission_offer_id')->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function setOffer($offer): void
    {
        $this->offer()->associate($offer);
    }

    public function setVendor($vendor): void
    {
        $this->vendor()->associate($vendor);
    }

    public function setCreatedBy($user): void
    {
        $this->createdBy()->associate($user);
    }

    public function setNumber()
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function getOffer(): OfferEntityInterface
    {
        return $this->offer()->first();
    }

    public function getVendor()
    {
        return $this->vendor()->first();
    }

    public function getCreatedBy()
    {
        return $this->createdBy()->first();
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }
}
