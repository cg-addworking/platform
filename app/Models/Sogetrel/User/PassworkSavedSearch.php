<?php

namespace App\Models\Sogetrel\User;

use App\Helpers\HasUuid;
use App\Models\Addworking\User\User;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PassworkSavedSearch extends Model implements Htmlable
{
    use HasUuid, Viewable, Routable;

    protected $table = 'sogetrel_user_passwork_saved_searches';

    protected $fillable = [
        'name',
        'search',
    ];

    protected $casts = [
        'search' => "array",
    ];

    protected $routePrefix = "sogetrel.user.passwork.saved.search";

    protected $routeParameterAliases = [
        'saved_search' => "passwork_saved_search",
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function passworkSavedSearchSchedule()
    {
        return $this->hasOne(PassworkSavedSearchSchedule::class, 'passwork_saved_search_id')->withDefault();
    }

    // ------------------------------------------------------------------------
    // Miscellaneous
    // ------------------------------------------------------------------------

    public function getQueryStringAttribute()
    {
        return http_build_query(["search" => $this->search]);
    }
}
