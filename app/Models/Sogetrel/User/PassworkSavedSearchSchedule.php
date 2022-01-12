<?php

namespace App\Models\Sogetrel\User;

use App\Helpers\HasUuid;
use App\Models\Sogetrel\User\PassworkSavedSearch;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class PassworkSavedSearchSchedule extends Model implements Htmlable
{
    use HasUuid,
        Viewable,
        Routable,
        SoftDeletes;

    protected $table = 'sogetrel_user_passwork_saved_scheduled_searches';

    protected $fillable = [
        'email',
        'frequency',
        'last_sent_at'
    ];

    protected $dates = [
        'last_sent_at',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function passworkSavedSearch()
    {
        return $this->belongsTo(PassworkSavedSearch::class, 'passwork_saved_search_id')->withDefault();
    }

    // ------------------------------------------------------------------------
    // Miscellaneous
    // ------------------------------------------------------------------------

    public function shouldRun()
    {
        return is_null($this->last_sent_at) || $this->last_sent_at->addDays($this->frequency)->isPast();
    }
}
