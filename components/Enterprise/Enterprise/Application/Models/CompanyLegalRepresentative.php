<?php

namespace Components\Enterprise\Enterprise\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Components\Common\Common\Application\Models\City;
use Components\Common\Common\Application\Models\Country;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyLegalRepresentativeEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyLegalRepresentative extends Model implements CompanyLegalRepresentativeEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = 'company_legal_representatives';

    protected $fillable = [
        'short_id',
        'quality',
        'starts_at',
        'ends_at',
        'denomination',
        'identification_number',
        'first_name',
        'last_name',
        'date_birth',
        'address',
        'additional_address',
    ];

    protected $casts = [
        'short_id' => 'integer',
        'quality' => 'string' ,
        'denomination' => 'string',
        'identification_number' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'date_birth' => 'date',
        'address' => 'string',
        'additional_address' => 'string',
        'starts_at' => 'date',
        'ends_at' => 'date',
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

    public function legalForm()
    {
        return $this->belongsTo(LegalForm::class, 'legal_form_id')->withDefault();
    }

    public function cityBirth()
    {
        return $this->belongsTo(City::class, 'city_birth_id')->withDefault();
    }

    public function countryBirth()
    {
        return $this->belongsTo(Country::class, 'country_birth_id')->withDefault();
    }

    public function countryNationality()
    {
        return $this->belongsTo(Country::class, 'country_nationality_id')->withDefault();
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id')->withDefault();
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function companyHolding()
    {
        return $this->belongsTo(Company::class, 'company_holding_id')->withDefault();
    }

    public function getCityBirth()
    {
        return $this->cityBirth()->first();
    }

    public function getCountryBirth()
    {
        return $this->countryBirth()->first();
    }

    public function getCountryNationality()
    {
        return $this->countryNationality()->first();
    }

    public function getCity()
    {
        return $this->city()->first();
    }

    public function getCountry()
    {
        return $this->country()->first();
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function getQuality(): string
    {
        return $this->quality;
    }

    public function getStartsAt()
    {
        return $this->starts_at;
    }

    public function getEndsAt(): ?string
    {
        return $this->ends_at;
    }

    public function getIdentificationNumber(): ?string
    {
        return $this->identification_number;
    }

    public function getDateBirth()
    {
        return $this->date_birth;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getAdditionalAddress()
    {
        return $this->additional_address;
    }

    public function getOriginData()
    {
        return $this->origin_data;
    }

    public function getFullAddress()
    {
        $address = '';
        $address .= !is_null($this->address) ? $this->address . ', ' : '';
        $address .= !is_null($this->additional_address) ? $this->additional_address . ', ' : '';
        $address .= !is_null($this->getCity()) ? $this->getCity()->getName() . ' ,' : '';
        $address .= !is_null($this->getCountry()) ? $this->getCountry()->getCode() : '';

        return $address;
    }
}
