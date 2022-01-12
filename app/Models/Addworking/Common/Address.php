<?php

namespace App\Models\Addworking\Common;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Site;

use App\Models\Everial\Mission\Offer;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class Address extends Model implements Htmlable
{
    use HasUuid, Routable, Viewable;

    protected $table = 'addworking_common_addresses';

    /**
     * @todo replace 'address' by 'street'
     * @todo replace 'additionnal_address' by 'additionnal'
     */
    protected $fillable = [
        'address',
        'additionnal_address',
        'zipcode',
        'town',
        'country',
    ];

    protected $attributes = [
        'country' => "fr",
    ];

    protected $uuidVersion = 5;

    public function __toString()
    {
        return $this->oneLine();
    }

    public function toHtml()
    {
        return $this->views()->html();
    }

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function enterprises()
    {
        return $this->morphedByMany(Enterprise::class, 'addressable', 'addworking_common_addressables');
    }

    public function sites()
    {
        return $this->morphedByMany(Site::class, 'addressable', 'addworking_common_addressables');
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function getTownZipcodeAttribute()
    {
        return "{$this->town} ({$this->zipcode})";
    }

    public function getOneLineAttribute()
    {
        return $this->oneLine();
    }

    public function setTownAttribute($value)
    {
        $this->attributes['town'] = strtoupper($value);
    }

    // ------------------------------------------------------------------------
    // Miscellaneous
    // ------------------------------------------------------------------------

    public function oneLine(): string
    {
        $str = $this->address;

        if ($this->additionnal_address) {
            $str .= " - $this->additionnal_address";
        }

        return "$str, $this->zipcode $this->town";
    }

    public function getUuidNode(): string
    {
        // -----------
        // - WARNING -
        // -----------
        // do NOT change this method or every existing UUID will become
        // obsolete.
        //
        return vsprintf('%s %s %s %s %s', [
            $this->address,
            $this->additionnal_address,
            $this->zipcode,
            $this->town,
            $this->country
        ]);
    }

    public static function firstOrCreate(array $attributes, array $values = [])
    {
        if (isset($attributes['town'])) {
            $attributes['town'] = strtoupper($attributes['town']);
        }

        return (new self)->newQuery()->firstOrCreate($attributes, $values);
    }
}
