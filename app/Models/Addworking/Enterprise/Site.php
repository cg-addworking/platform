<?php

namespace App\Models\Addworking\Enterprise;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Site extends Model implements Htmlable
{
    use HasUuid, Viewable, Routable;

    protected $table = 'addworking_enterprise_sites';

    protected $fillable = [
        'name',
        'display_name',
        'analytic_code',
    ];

    protected $routePrefix = "addworking.enterprise.site";

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id');
    }

    public function addresses()
    {
        return $this->morphToMany(Address::class, 'addressable', 'addworking_common_addressables');
    }

    public function phoneNumbers()
    {
        return $this->morphToMany(PhoneNumber::class, 'morphable', 'addworking_common_has_phone_numbers')
            ->withPivot('note');
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeOfName($query, $site)
    {
        return $query->where('display_name', 'like', "%".strtoupper($site)."%");
    }

    public function scopeOfCode($query, $code)
    {
        return $query->where('analytic_code', 'like', "%".$code."%");
    }

    public function scopeOfPhone($query, $phone)
    {
        return $query->whereHas('phoneNumbers', function ($query) use ($phone) {
            $query->where(function ($query) use ($phone) {
                $query->where('number', 'like', "%{$phone}%");
            });
        });
    }

    public function scopeOfAddress($query, $address)
    {
        $address = strtolower($address);
        return $query->whereHas('addresses', function ($query) use ($address) {
            $query->where(function ($query) use ($address) {
                $query->where(DB::raw('LOWER(address)'), 'like', "%{$address}%")
                    ->orWhere(DB::raw('LOWER(additionnal_address)'), 'like', "%{$address}%")
                    ->orWhere('zipcode', 'like', "%{$address}%")
                    ->orWhere(DB::raw('LOWER(town)'), 'like', "%{$address}%")
                    ->orWhere(DB::raw('LOWER(country)'), 'like', "%{$address}%");
            });
        });
    }

    public function scopeCreatedAt($query, $date)
    {
        return $query->where('created_at', 'like', "%{$date}%");
    }
}
