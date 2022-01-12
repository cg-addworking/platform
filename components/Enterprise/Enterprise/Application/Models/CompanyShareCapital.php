<?php

namespace Components\Enterprise\Enterprise\Application\Models;

use App\Helpers\HasUuid;
use Components\Common\Common\Application\Models\Currency;
use Components\Enterprise\Enterprise\Application\Models\Company;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyShareCapitalEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyShareCapital extends Model implements CompanyShareCapitalEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = 'company_share_capitals';

    protected $fillable = [
        'short_id',
        'amount',
    ];

    protected $casts = [
        'short_id' => 'integer',
        'amount' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $attributes = [
        'amount' => 1,
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id')->withDefault();
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id')->withDefault();
    }

    public function getCurency()
    {
        return $this->currency()->first();
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }
}
