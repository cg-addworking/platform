<?php

namespace App\Models\Everial\Mission;

use App\Helpers\HasUuid;
use App\Contracts\Models\Searchable;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Offer;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use UnexpectedValueException;

class Referential extends Model implements Htmlable, Searchable
{
    use SoftDeletes,
        HasUuid,
        Viewable,
        Routable;

    const PALLET_TYPE_115X115 = "115x115";

    protected $table = 'everial_mission_referential_missions';

    protected $fillable = [
        'shipping_site',
        'shipping_address',
        'destination_site',
        'destination_address',
        'distance',
        'pallet_number',
        'pallet_type',
        'analytic_code',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $attributes = [
        'distance'      => 0,
        'pallet_number' => 0,
        'pallet_type'   => self::PALLET_TYPE_115X115,
    ];

    protected $routePrefix = 'everial.mission.referential';

    protected $searchable = [
        'shipping_site',
        'shipping_address',
        'destination_site',
        'destination_address',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function bestBidder()
    {
        return $this->belongsTo(Enterprise::class, 'best_bidder_vendor_id')->withDefault();
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function getLabelAttribute()
    {
        return "{$this->shipping_site} - {$this->destination_site}".
            " - {$this->pallet_number} palette(s) {$this->pallet_type}";
    }

    public function setShippingAddressAttribute($value)
    {
        $this->attributes['shipping_address'] = strtoupper(remove_accents($value));
    }

    public function setDestinationAddressAttribute($value)
    {
        $this->attributes['destination_address'] = strtoupper(remove_accents($value));
    }

    public function setShippingSiteAttribute($value)
    {
        $this->attributes['shipping_site'] = strtoupper(remove_accents($value));
    }

    public function setDestinationSiteAttribute($value)
    {
        $this->attributes['destination_site'] = strtoupper(remove_accents($value));
    }

    public function setPalletTypeAttribute($value)
    {
        $this->attributes['pallet_type'] = trim(strtolower($value));
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeSearch($query, string $search): Builder
    {
        $search = strtolower($search);

        return $query
            ->orWhere(function ($query) use ($search) {
                foreach ($this->searchable as $column) {
                    $query->orWhere(DB::raw("LOWER(CAST({$column} as TEXT))"), 'LIKE', "%{$search}%");
                }
            });
    }

    public function scopeShippingSite($query, $shipping_site)
    {
        return $query->where('shipping_site', 'like', "%".strtoupper(remove_accents($shipping_site))."%");
    }

    public function scopeShippingAddress($query, $shipping_address)
    {
        return $query->where('shipping_address', 'like', "%".strtoupper(remove_accents($shipping_address))."%");
    }

    public function scopeDestinationSite($query, $destination_site)
    {
        return $query->where('destination_site', 'like', "%".strtoupper(remove_accents($destination_site))."%");
    }

    public function scopeDestinationAddress($query, $destination_address)
    {
        return $query->where('destination_address', 'like', "%".strtoupper(remove_accents($destination_address))."%");
    }

    public function scopePalletNumber($query, $pallet_number)
    {
        return $query->where('pallet_number', $pallet_number);
    }

    // ------------------------------------------------------------------------
    // Miscellaneous
    // ------------------------------------------------------------------------

    public function getPositionedVendors()
    {
        $vendors = collect();
        foreach ($this->prices as $price) {
            $vendors->push($price->vendor);
        }

        return $vendors;
    }

    public static function getBestBidderFromOffer(Offer $offer, Enterprise $vendor): bool
    {
        return $offer->everialReferentialMissions()->firstOrNew([])->bestBidder->is($vendor);
    }

    public static function getAvailableAnalyticCodes(): array
    {
        return [
            'D4120' => "D4120 CONSERVATION TRADITIONNELLE",
            'D4110' => "D4110 CONSERVATION DYNAMIQUE",
            'D4200' => "D4200 CONSERVATION HAUTE SECURITE",
            'D1220' => "D1220 PEC ENTREE EN STOCK TRAD",
            'D1120' => "D1120 PEC ENLEVEMENT TRADITIONNEL",
            'D1110' => "D1110 PEC ENLEVEMENT DYNAMIQUE",
            'D1290' => "D1290 PEC INITIALE",
            'D5200' => "D5200 GESTION TRANSPORT",
            'D7000' => "D7000 FOURNITURES",
            'D5120' => "D5120 GESTION",
            'D2000' => "D2000 NUMERISATION",
            'D6120' => "D6120 TRANSPORT ELIMINATION",
        ];
    }
}
