<?php

namespace App\Models\Addworking\Enterprise;

use App\Helpers\HasUuid;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use UnexpectedValueException;

class LegalForm extends Model implements Htmlable
{
    use HasUuid, Routable, Viewable;

    const SAS = 'sas';
    const SASU = 'sasu';
    const SA = 'sa';
    const SARL = 'sarl';
    const SARLU = 'sarlu';
    const EURL = 'eurl';
    const EIRL = 'eirl';
    const EI = 'ei';
    const MICRO = 'micro';

    protected $table = "addworking_enterprise_legal_forms";

    protected $fillable = [
        'name',
        'display_name',
        'country',
    ];

    protected $routePrefix = "support.enterprise.legal_form";

    public function __toString()
    {
        return $this->display_name ?? 'n/a';
    }

    public function setCountryAttribute($value)
    {
        if (! in_array($value, self::getAvailableCountries())) {
            throw new UnexpectedValueException("Invalid country: $value");
        }

        $this->attributes['country'] = $value;
    }

    public static function getAvailableCountries(): array
    {
        return ['fr', 'de', 'be'];
    }

    public function getDisplayName(): string
    {
        return $this->display_name;
    }
}
