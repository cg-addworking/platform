<?php

namespace Components\Contract\Contract\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\File;
use Components\Contract\Contract\Domain\Interfaces\Entities\SubcontractingDeclarationEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubcontractingDeclaration extends Model implements SubcontractingDeclarationEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "contract_subcontracting_declaration";

    protected $fillable = [
        'validation_date',
        'percent_of_aggregation',
    ];

    protected $dates = [
        'validation_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    ////////////////////////////////////////////////
    /// Relationships                           ///
    ///////////////////////////////////////////////

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id')->withDefault();
    }

    public function file()
    {
        return $this->belongsTo(File::class, "file_id")->withDefault();
    }

    ////////////////////////////////////////////////
    /// Setters                                 ///
    ///////////////////////////////////////////////

    public function setContract($value)
    {
        $this->contract()->associate($value);
    }

    public function setFile($value)
    {
        $this->file()->associate($value);
    }

    public function setValidationDate($value)
    {
        $this->validation_date = $value;
    }

    public function setPercentOfAggregation($value)
    {
        $this->percent_of_aggregation = $value;
    }

    ////////////////////////////////////////////////
    /// Getters                                 ///
    ///////////////////////////////////////////////

    public function getId()
    {
        return $this->id;
    }

    public function getContract()
    {
        return $this->contract()->first();
    }

    public function getFile()
    {
        return $this->file()->first();
    }

    public function getValidationDate()
    {
        return $this->validation_date;
    }

    public function getPercentOfAggregation()
    {
        return $this->percent_of_aggregation;
    }
}
