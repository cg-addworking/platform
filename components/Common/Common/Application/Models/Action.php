<?php

namespace Components\Common\Common\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\User\User;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Illuminate\Database\Eloquent\Model;

class Action extends Model implements ActionEntityInterface
{
    use HasUuid;

    protected $table = "addworking_common_actions";

    protected $fillable = [
        'message',
        'display_name',
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function actions()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setUser(?User $user)
    {
        $this->user()->associate($user);
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function setModel(Model $model): void
    {
        $this->trackable_id = $model->id;
        $this->trackable_type = get_class($model);
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDisplayName(string $displayName): void
    {
        $this->display_name = $displayName;
    }
    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------

    public function getUser(): ?User
    {
        return $this->user()->first();
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDisplayName(): string
    {
        return $this->display_name;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
