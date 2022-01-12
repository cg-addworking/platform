<?php

namespace Components\Contract\Contract\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Contract\Domain\Interfaces\Entities\AnnexEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Annex extends Model implements AnnexEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "addworking_contract_annexes";

    protected $fillable = [
        'number',
        'name',
        'display_name',
        'description',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class, "file_id")->withDefault();
    }

    public function setEnterprise($enteprise)
    {
        $this->enterprise()->associate($enteprise);
    }

    public function setFile($value)
    {
        $this->file()->associate($value);
    }

    public function setNumber()
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setDisplayName(string $display_name)
    {
        $this->display_name = Str::slug($display_name);
    }

    public function setDescription(?string $description)
    {
        $this->description = $description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEnterprise()
    {
        return $this->enterprise()->first();
    }

    public function getFile()
    {
        return $this->file()->first();
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDisplayName(): string
    {
        return $this->display_name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function scopeFilterEnterprise($query, $enterprises)
    {
        return $query->whereHas('enterprise', function ($query) use ($enterprises) {
            return $query->whereIn('id', Arr::wrap($enterprises));
        });
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}
