<?php

namespace Components\Enterprise\Enterprise\Application\Models;

use App\Helpers\HasUuid;
use Components\Common\Common\Application\Models\City;
use Components\Common\Common\Application\Models\Country;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyEstablishmentEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyEstablishment extends Model implements CompanyEstablishmentEntityInterface
{
    use HasUuid, SoftDeletes;

    // @todo: change to company_establishments when name of table is changed
    protected $table = 'addworking_enterprise_enterprises';

    protected $fillable = [
        'short_id',
        'identification_number',
        'establishment_name',
        'commercial_name',
        'code',
        'address',
        'additional_address',
        'latitude',
        'longitude',
        'creation_date',
        'cessation_date',
        'is_headquarter',
        'origin_data'
    ];

    protected $casts = [
        'short_id' => 'integer',
        'identification_number' => 'string',
        'establishment_name' => 'string',
        'commercial_name' => 'string',
        'code' => 'string',
        'address' => 'string',
        'additional_address' => 'string',
        'latitude' => 'float',
        'longitude' => 'float',
        'creation_date' => 'date',
        'cessation_date' => 'date',
        'is_headquarter' => 'boolean',
        'origin_data' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id')->withDefault();
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id')->withDefault();
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id')->withDefault();
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id')->withDefault();
    }

    public function getCity()
    {
        return $this->city()->first();
    }

    public function getCountry()
    {
        return $this->country()->first();
    }

    public function getFullAddress(): string
    {
        $address = '';
        $address .= !is_null($this->getAddress()) ? $this->getAddress() . ', ' : '';
        $address .= !is_null($this->getAdditionalAddress()) ? $this->getAdditionalAddress() . ', ' : '';
        $address .= !is_null($this->getCity()) ? $this->getCity()->getZipCode() . ' ' : '';
        $address .= !is_null($this->getCity()) ? $this->getCity()->getName() . ' ,' : '';
        $address .= !is_null($this->getCountry()) ? $this->getCountry()->getCode() : '';

        return $address;
    }

    public function getIdentificationNumber(): string
    {
        return $this->identification_number;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getEstablishmentName(): ?string
    {
        return $this->establishment_name;
    }

    public function getCommercialName(): ?string
    {
        return $this->commercial_name;
    }

    public function getCreationDate()
    {
        return $this->creation_date;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getAdditionalAddress(): ?string
    {
        return $this->additional_address;
    }

    public function getCessationDate()
    {
        return $this->cessation_date;
    }

    public function getIsHeadquarter(): bool
    {
        return $this->is_headquarter;
    }

    public function getOriginData(): ?string
    {
        return $this->origin_data;
    }
}
