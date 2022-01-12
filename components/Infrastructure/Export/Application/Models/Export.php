<?php

namespace Components\Infrastructure\Export\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\User\User;
use Components\Infrastructure\Export\Domain\Interfaces\ExportEntityInterface;
use Illuminate\Database\Eloquent\Model;

class Export extends Model implements ExportEntityInterface
{
    use HasUuid;

    protected $table = "addworking_common_exports";

    /**
     * @var array
     */
    protected $casts = [
        'filters' => 'array',
    ];

    protected $dates = [
        'finished_at',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class)->withDefault();
    }

    public function setUser(User $user)
    {
        $this->user()->associate($user);
    }

    public function setFile(File $file)
    {
        $this->file()->associate($file);
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setErrorMessage(string $error_message): void
    {
        $this->error_message = $error_message;
    }

    public function setFinishedAt($finished_at): void
    {
        $this->finished_at = $finished_at;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setFilters($filters)
    {
        $this->filters = $filters;
    }

    public function getUser(): User
    {
        return $this->user()->first();
    }

    public function getFile(): ?File
    {
        return $this->file()->first();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function getFinishedAt()
    {
        return $this->finished_at;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }
}
