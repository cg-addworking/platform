<?php

namespace Components\Mission\Mission\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\File;
use Components\Mission\Mission\Domain\Interfaces\Entities\CostEstimationEntityInterface;
use Components\Mission\Offer\Application\Models\Offer;
use Illuminate\Database\Eloquent\Model;

class CostEstimation extends Model implements CostEstimationEntityInterface
{
    use HasUuid;

    protected $table = 'mission_cost_estimations';

    protected $fillable = [
        'price_ht'
    ];

    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function mission()
    {
        return $this->hasMany(Mission::class, 'cost_estimation_id')->withDefault();
    }

    public function offer()
    {
        return $this->hasMany(Offer::class, 'cost_estimation_id')->withDefault();
    }

    // ------------------------------------------------------------------------
    // Setters
    // ------------------------------------------------------------------------
    public function setFile($file)
    {
        $this->file()->associate($file)->save();
    }

    public function setAmountBeforeTaxes($value): void
    {
        $this->amount_before_taxes = $value;
    }

    // ------------------------------------------------------------------------
    // Getters
    // ------------------------------------------------------------------------
    public function getFile()
    {
        return $this->file()->first();
    }

    public function getAmountBeforeTaxes(): ?float
    {
        return $this->amount_before_taxes;
    }
}
