<?php

namespace Components\Enterprise\Resource\Application\Models;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Contracts\Models\Searchable;
use App\Models\Addworking\Common\Concerns\File\HasAttachments;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\Resource\Application\Models\Concerns\ResourceScopes;
use Components\Enterprise\Resource\Domain\Classes\ResourceInterface;
use Components\Infrastructure\Scopes\DateScopes;
use Components\Infrastructure\Scopes\StatusScopes;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model implements ResourceInterface, Searchable, Htmlable
{
    use DateScopes,
        HasAttachments,
        HasUuid,
        ResourceScopes,
        StatusScopes,
        Viewable,
        Routable,
        SoftDeletes;

    protected $table = "addworking_enterprise_resources";

    protected $viewPrefix = "resource::";

    protected $routePrefix = "addworking.enterprise.resource";

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'registration_number',
        'status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $searchable = [
        'number',
        'first_name',
        'last_name',
        'email',
        'registration_number',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function activityPeriods()
    {
        return $this->hasMany(ActivityPeriod::class);
    }

    public function enterprise()
    {
        return $this->vendor();
    }

    public function vendor()
    {
        return $this->belongsTo(Enterprise::class, 'vendor_id')->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registration_number;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getVendor()
    {
        return $this->vendor()->first();
    }

    public function getId(): string
    {
        return $this->id;
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------

    public function setFirstName(?string $first_name)
    {
        $this->first_name = ucwords($first_name);
    }

    public function setLastName(?string $last_name)
    {
        $this->last_name = strtoupper($last_name);
    }

    public function setVendor($vendor)
    {
        $this->vendor()->associate($vendor);
    }

    public function setCreator($user)
    {
        $this->createdBy()->associate($user);
    }

    public function setEmail($email)
    {
        $this->email = strtolower($email);
    }

    public function setNumber()
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setRegistrationNumber(?string $registration_number)
    {
        $this->registration_number = $registration_number;
    }

    public function setStatus(?string $status)
    {
        $this->status = $status;
    }

    public function setNote(?string $note)
    {
        $this->note = $note;
    }
}
