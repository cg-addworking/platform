<?php

namespace App\Models\Sogetrel\Enterprise;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InvalidArgumentException;

class Data extends Model implements Htmlable
{
    use SoftDeletes,
        Viewable,
        Routable,
        HasUuid;

    protected $table = 'sogetrel_enterprise_enterprise_data';

    protected $fillable = [
        'navibat_id',               // Sogetrel Navibat ID
        'compta_marche_group',      // Specific accounting and financial data
        'compta_marche_tva_group',  // Specific accounting and financial data
        'compta_produit_group',     // Specific accounting and financial data
        'navibat_sent',             // Check if vendor is sent at Sogetrel Navibat
        'oracle_id',                // Sogetrel Oracle ID
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    // ------------------------------------------------------------------------
    // Attribute
    // ------------------------------------------------------------------------

    public function setComptaMarcheGroupAttribute($value)
    {
        if (!in_array($value, static::getAvailableComptaMarcheGroups())) {
            throw new InvalidArgumentException("invalid status: {$value}");
        }

        $this->attributes['compta_marche_group'] = $value;
    }

    public function setComptaMarcheTvaGroupAttribute($value)
    {
        if (!in_array($value, static::getAvailableComptaMarcheTvaGroups())) {
            throw new InvalidArgumentException("invalid status: {$value}");
        }

        $this->attributes['compta_marche_tva_group'] = $value;
    }

    public function setComptaProduitGroupAttribute($value)
    {
        if (!in_array($value, static::getAvailableComptaProduitGroups())) {
            throw new InvalidArgumentException("invalid status: {$value}");
        }

        $this->attributes['compta_produit_group'] = $value;
    }

    public function setNavibatIdAttribute($value)
    {
        $this->attributes['navibat_id'] = "ADW" . str_pad($value, 6, "0", STR_PAD_LEFT);
    }

    // ------------------------------------------------------------------------
    // Misc
    // ------------------------------------------------------------------------

    public static function getAvailableComptaProduitGroups(): array
    {
        return [
            'ANCIEN'    , 'AUTO'  , 'COR',
            'DOC'       , 'EXCLU' , 'EXO',
            'NORM'      , 'NORMA' , 'NORMI',
            'NUITE SUIS', 'REDUIT', 'REDUIT2',
            'REDUIT3'   , 'SITU'  , 'SPEC'   , 'SPECSUISSE',
            'NORMT', //default value
        ];
    }

    public static function getAvailableComptaMarcheTvaGroups(): array
    {
        return [
            'BELG-DEB', 'BELGIQUE'  , 'CEE',
            'CEEBEL'  , 'CORSE'     , 'CORSE-ENC',
            'DOM-DEB' , 'DOM-ENCAI' , 'DOM-EXO',
            'FR-DEBIT', 'FR-EXO'    , 'GUYANE',
            'HORS-CEE', 'MAYOTTE'   , 'PART.FR',
            'SUIS-DEB', 'SUIS-ENCAI', 'SUIS-EXO',
            'FR-ENCAISS', // default value
        ];
    }

    public static function getAvailableComptaMarcheGroups(): array
    {
        return [
            'AUTO'      , 'AUTO DOM'  , 'BELGIQUE' , 'CEE',
            'COMALIA'   , 'COMELEC'   , 'CORSE'    , 'DOM TOM',
            'GRESELLE C', 'GRESELLE E', 'GUYANE'   , 'HOLDING',
            'HORS-CEE'  , 'HORS-SUISS', 'INTERCOS' , 'MAYOTTE',
            'OTAN'      , 'SOGETREL'  , 'SOG-RADIO', 'SOG-SUISSE',
            'SUBWAY'    , 'SUISSE'    , 'TBF'      , 'TVEE',
            'FRANCE', //default value
        ];
    }
}
