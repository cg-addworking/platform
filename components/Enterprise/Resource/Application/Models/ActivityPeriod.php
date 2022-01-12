<?php

namespace Components\Enterprise\Resource\Application\Models;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Contracts\Models\Searchable;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\Resource\Application\Models\Concerns\ActivityPeriodScopes;
use Components\Enterprise\Resource\Domain\Classes\ActivityPeriodInterface;
use Components\Enterprise\Resource\Domain\Classes\ResourceInterface;
use DateTime;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ActivityPeriod extends Model implements ActivityPeriodInterface, Searchable, Htmlable
{
    use ActivityPeriodScopes,
        HasUuid,
        Routable,
        Viewable;

    protected $table = "addworking_enterprise_resource_activity_periods";

    protected $viewPrefix = "resource::activity_period";

    protected $routePrefix = "addworking.enterprise.assigned_resource";

    protected $fillable = [
        'starts_at',
        'ends_at',
    ];

    protected $dates = [
        'starts_at',
        'ends_at',
    ];

    protected $searchable = [];

    // ------------------------------------------------------------------------
    // Relationships

    public function customer()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class)->withDefault();
    }

    // ------------------------------------------------------------------------
    // Interface methods

    public function getCustomer(): Enterprise
    {
        return $this->customer;
    }

    public function setCustomer(Enterprise $enterprise): void
    {
        $this->customer()->associate($enterprise);
    }

    public function getResource(): ResourceInterface
    {
        return $this->resource;
    }

    public function setResource(ResourceInterface $resource): void
    {
        $this->resource()->associate($resource);
    }

    public function getStartsAt(): DateTime
    {
        return $this->starts_at;
    }

    public function setStartsAt(DateTime $value): void
    {
        $this->starts_at = $value;
    }

    public function getEndsAt(): DateTime
    {
        return $this->ends_at;
    }

    public function setEndsAt(DateTime $value): void
    {
        $this->ends_at = $value;
    }
}
