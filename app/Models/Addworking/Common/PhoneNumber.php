<?php

namespace App\Models\Addworking\Common;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Site;
use App\Models\Addworking\User\User;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model implements Htmlable
{
    use HasUuid, Viewable, Routable;

    protected $table = 'addworking_common_phone_numbers';

    protected $fillable = [
        'number',
    ];

    public function __toString()
    {
        return (string) $this->number;
    }

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function enterprises()
    {
        return $this->morphedByMany(Enterprise::class, 'morphable', 'addworking_common_has_phone_numbers')
            ->withPivot('note');
    }

    public function sites()
    {
        return $this->morphedByMany(Site::class, 'morphable', 'addworking_common_has_phone_numbers')
            ->withPivot('note');
    }

    // ------------------------------------------------------------------------
    // Miscellaneous
    // ------------------------------------------------------------------------

    public static function fromNumber($number)
    {
        return static::where('number', $number)->first();
    }
}
