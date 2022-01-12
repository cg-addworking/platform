<?php

namespace App\Models\Addworking\Enterprise;

use App\Helpers\HasUuid;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model implements Htmlable
{
    use SoftDeletes,
        Viewable,
        Routable,
        HasUuid;

    protected $table = 'addworking_enterprise_enterprise_logs';

    protected $fillable = [
        'domain',       // e.g. addworking ...
        'type',         // e.g. info, error, warning ...
        'process_type', // e.g. jobs, mails ....
        'process_name', // e.g. classname ...
        'message',
        'content'
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
}
