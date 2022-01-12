<?php

namespace App\Models\Addworking\Common;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Contracts\Models\Searchable;
use App\Events\DeletingFile;
use App\Jobs\Addworking\Common\File\SendToStorageJob;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\PurchaseOrder;
use App\Models\Addworking\User\User;
use App\Models\Concerns\HasFilters;
use Carbon\Carbon;
use Components\Common\Common\Domain\Collections\FileCollection;
use Components\Common\Common\Domain\Interfaces\FileCollectionInterface;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SplFileInfo;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use UnexpectedValueException;

class File extends Model implements Htmlable, Searchable
{
    use SoftDeletes,
        HasUuid,
        HasFilters,
        Viewable,
        Routable;

    protected $table = 'addworking_common_files';

    protected $fillable = [
        'path',
        'mime_type',
        'size',
        'content',
        'md5',
        'name',
    ];

    protected $dispatchesEvents = [
        'deleting' => DeletingFile::class,
    ];

    protected $dates = [
        'deleted_at',
    ];

    protected $routeParameterAliases = [
        'id' => 'file',
    ];

    public function __toString()
    {
        return $this->basename ?? 'n/a';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if ($model->content) {
                $model->md5 = md5($model->content);
            }

            if (!$model->size && $model->content) {
                $model->size = strlen($model->content);
            }
        });

        self::updating(function ($model) {
            if ($model->isDirty('content')) {
                $model->md5 = md5($model->content);
            }

            if (!$model->isDirty('size') && $model->isDirty('content')) {
                $model->size = strlen($model->content);
            }
        });

        self::saved(function ($model) {
            if ($model->content) {
                SendToStorageJob::dispatchNow($model->id, $model->content);
            }
        });
    }

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function attachable()
    {
        return $this->morphTo();
    }

    public function attachTo($model)
    {
        return $this->attachable()->associate($model);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function enterprises()
    {
        return $this
            ->belongsToMany(Document::class, 'addworking_enterprise_documents')
            ->withTimestamps();
    }

    public function detachFrom($model)
    {
        return $this->attachable()->dissociate($model);
    }

    public function logoEnterprise()
    {
        return $this->hasOne(Enterprise::class, 'logo_id');
    }

    public function owner()
    {
        return $this->user()->withDefault();
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id')->withDefault();
    }

    public function purchaseOrder()
    {
        return $this->hasOne(PurchaseOrder::class, 'file_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    /**
     * @param $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, string $search): Builder
    {
        $search = str_replace(' ', '', strtolower($search));
        return $query->where(DB::raw('LOWER(path)'), 'like', "%{$search}%");
    }

    /**
     * Filters Files that are of the given mime-type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMimeType($query, $type)
    {
        return $query->where('mime_type', $type);
    }

    /**
     * Filters Files that belong to a given owner.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $owner
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOwner($query, $owner)
    {
        return $query->whereHas('owner', function ($query) use ($owner) {
            $query->where('firstname', 'like', "%$owner%")
                ->orWhere('lastname', 'like', "%$owner%");
        });
    }

    /**
     * Filters Files that are in the given path.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $path
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePath($query, $path)
    {
        return $query->where('path', 'like', "%$path%");
    }

    /**
     * Filters that are of the given date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCreatedAt($query, $date)
    {
        return $query->where('created_at', 'like', "%{$date}%");
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    /**
     * @return bool|string
     */
    public function getContentAttribute()
    {
        $content = $this->attributes['content'] ?? '';

        if (is_resource($content)) {
            $content = stream_get_contents($content);
        }

        try {
            return ( $content === '' && Config::get('files.storage.enabled', false) )
                ? Storage::disk(Config::get('files.storage.disk'))->get($this->attributes['id'])
                : base64_decode($content);
        } catch (FileNotFoundException $e) {
            return '';
        }
    }

    /**
     * @param string $content
     */
    public function setContentAttribute(string $content)
    {
        $this->attributes['content'] = base64_encode($content);
    }

    /**
     * @return string
     */
    public function getSizeForHumansAttribute()
    {
        return human_filesize((int)$this->size);
    }

    public function getBasenameAttribute(): string
    {
        return basename($this->path);
    }

    public function getExtensionAttribute(): string
    {
        return preg_match('/\.(\w+)$/', $this->basename, $matches) ? $matches[1] : '';
    }

    public function getIsImageAttribute()
    {
        return ends_with($this->mime_type, '/image');
    }

    // S3 Bucket Url of file
    public function getUrlAttribute()
    {
        $disk = Config::get('files.storage.disk');

        return Storage::disk($disk)->exists($this->id) ? Storage::disk($disk)->url($this->id) : "#";
    }

    // S3 Bucket Temporary Url of file
    public function getTemporaryUrlAttribute()
    {
        $disk = Config::get('files.storage.disk');

        return ($disk === 'files_s3' && Storage::disk($disk)->exists($this->id)) ?
            Storage::disk($disk)->temporaryUrl($this->id, Carbon::now()->addSeconds(360)) :
            null;
    }

    public function getCommonUrlAttribute()
    {
        return (Config::get('files.storage.disk') === 'files_s3') ?
            $this->getTemporaryUrlAttribute() :
            $this->getUrlAttribute();
    }

    // ------------------------------------------------------------------------
    // Miscellaneous
    // ------------------------------------------------------------------------

    /**
     * @param $fileId
     * @return Model|\Illuminate\Database\Query\Builder|null|object
     */
    public static function getEnterpriseFile($fileId)
    {
        return DB::table('addworking_enterprise_documents')->where('file_id', $fileId)->first();
    }

    /**
     * @param $path
     * @return File
     */
    public static function fromPath($path): self
    {
        return self::withTrashed()->wherePath($path)->firstOrFail();
    }

    public static function saveAndSendToStorage($file): self
    {
        switch (true) {
            case $file instanceof SymfonyFile:
                $content = $file->openFile('r')->fread($file->getSize());
                $file = new self([
                    'path' => uniqid('file_') . '.' . $file->guessExtension(),
                    'mime_type' => $file->getMimeType(),
                    'name' => $file->getClientOriginalName(),
                ]);
                break;

            case $file instanceof SplFileInfo:
                $content = $file->openFile('r')->fread($file->getSize());
                $file = new self([
                    'path' => $file->getPath(),
                    'mime_type' => mime_content_type($file->getPathname()),
                    'name' => $file->getClientOriginalName(),
                ]);
                break;

            default:
                throw new UnexpectedValueException('Invalid file');
        }

        $file->md5 = md5($content);
        $file->size = strlen($content);

        if (!$file->user && !auth()->guest()) {
            $file->user()->associate(auth()->user());
        }

        $saved = $file->saveAndGet();

        SendToStorageJob::dispatchNow($saved->id, $content);

        return $saved;
    }

    /**
     * @param $file
     * @return File
     */
    public static function from($file): self
    {
        /**
         * @todo move this giant switch to a pipeline!
         */
        switch (true) {
            case $file instanceof self:
                // noop
                break;

            case is_array($file):
                $file = new self($file);
                break;

            case $file instanceof SymfonyFile:
                $file = new self([
                    'path'      => str_random(16) . '.' . $file->guessExtension(),
                    'mime_type' => $file->getMimeType(),
                    'content'   => $file->openFile('r')->fread($file->getSize()),
                    'name'      => $file->getClientOriginalName(),
                ]);
                break;

            case $file instanceof SplFileInfo:
                $file = new self([
                    'path'      => $file->getPath(),
                    'mime_type' => mime_content_type($file->getPathname()),
                    'content'   => $file->openFile('r')->fread($file->getSize()),
                    'name'      => $file->getClientOriginalName(),
                ]);
                break;

            case is_callable($file):
                $file = self::from($file());
                break;

            // if $file is binary octet-stream, it's very likely it will
            // contains NUL character ("\0") therefore detecting it
            // prevents sending it to is_readable - which otherwise would
            // trigger a warning.
            case strpos($file, "\0") === false && is_readable($file):
                $file = self::from(new SplFileInfo($file));
                break;

            case is_string($file):
                $file = new self([
                    'path'      => str_random(16) . '.txt',
                    'mime_type' => 'text/plain',
                    'content'   => $file,
                ]);
                break;

            default:
                throw new UnexpectedValueException('Invalid file');
        }

        if (!$file->user && !auth()->guest()) {
            $file->user()->associate(auth()->user());
        }

        return $file;
    }

    /**
     * @param string $name
     * @param mixed ...$args
     * @return File
     */
    public function name(string $name, ...$args): self
    {
        $created   = $this->created_at ?? Carbon::now();
        $extension = $this->getExtensionAttribute();
        $date      = $created->format('Y-m-d');
        $timestamp = $created->format('YmdHis');

        $placeholders = [
            '%ext%'       => $extension,
            '%extension%' => $extension,
            '%date%'      => $date,
            '%ts%'        => $timestamp,
            '%timestamp%' => $timestamp,
            '%uniq%'      => uniqid(),
        ];

        foreach ($placeholders as $placeholder => $value) {
            $name = str_replace($placeholder, $value, $name);
        }

        if (!empty($args)) {
            array_walk($args, function (&$item) {
                if ($item instanceof Model) {
                    $item = $item->getKey();
                }
            });

            $name = str_replace_array('?', $args, $name);
        }

        $this->path = $name;

        return $this;
    }

    public function download()
    {
        $disk = Config::get('files.storage.disk');

        if (Storage::disk($disk)->exists($this->id)) {
            return Storage::disk($disk)->download($this->id, $this->id. '.' . $this->getExtension());
        }
    }

    /**
     * @deprecated v0.66.7 in favor of getFileInfo
     */
    public function temp(): string
    {
        return $this->getFileInfo()->getPathname();
    }

    /**
     * @deprecated v0.66.7 in favor of getFileInfo
     */
    public function asSplFileObject(): \SplFileObject
    {
        return $this->getFileInfo()->openFile();
    }

    /**
     * Save the current file and return it.
     *
     * @return $this
     */
    public function saveAndGet(): self
    {
        $this->save();

        return $this;
    }

    // ------------------------------------------------------------------------
    // Interface methods
    // ------------------------------------------------------------------------

    public function getId(): string
    {
        if (! $this->exists()) {
            throw new \RuntimeException("this file doesn't exists");
        }

        return $this->id;
    }

    public function getFileInfo(): \SplFileInfo
    {
        if (! $this->exists) {
            throw new \RuntimeException("this file doesn't exists");
        }

        $content = Storage::exists($this->id)
            ? Storage::get($this->id)
            : $this->content;

        if (empty($content)) {
            throw new \RuntimeException("no content to write, file {$this->id} is empty!");
        }

        $path = sprintf('%s/%s', sys_get_temp_dir(), $this->id);

        if ($ext = $this->getExtension()) {
            $path .= ".{$ext}";
        }

        if (! file_put_contents($path, $content)) {
            throw new \RuntimeException("unable to write {$path}");
        }

        return new \SplFileInfo($path);
    }

    public function hasParent(): bool
    {
        return $this->parent()->exists();
    }

    public function getParent()
    {
        return $this->parent()->exists() ? $this->parent : null;
    }

    public function setParent($file)
    {
        $this->parent()->associate($file);

        return $this;
    }

    public function getChildren(): FileCollectionInterface
    {
        $collection = new FileCollection;

        foreach ($this->children()->cursor() as $child) {
            $collection->push($child);
        }

        return $collection;
    }

    public function getOwner()
    {
        if (! $this->user()->exists()) {
            throw new \RuntimeException("no owner defined for file {$this->id}");
        }

        return $this->user;
    }

    public function setOwner($user): self
    {
        $this->user()->associate($user);

        return $this;
    }

    public function getName(): string
    {
        return $this->path ?? '';
    }

    public function setName(string $name)
    {
        $this->path = $name;

        return $this;
    }

    public function getMimeType(): string
    {
        if ($this->mime_type) {
            return $this->mime_type;
        }

        if ($this->path) {
            return mime_content_type($this->path);
        }

        return 'application/octet-stream';
    }

    public function setMimeType(string $mime)
    {
        $this->mime_type = $mime;

        return $this;
    }

    public function getExtension(): ?string
    {
        if ($this->path && preg_match('/\.(\w+)$/', $this->path, $matches)) {
            return $matches[1];
        }

        if ($this->getMimeType() == 'text/plain') {
            return 'txt';
        }

        if ($this->getMimeType() != 'application/octet-stream') {
            return explode('/', $this->getMimeType())[1] ?? null;
        }

        return null;
    }

    public function getContent(): string
    {
        return $this->content ?? '';
    }

    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
    }

    public function isText(): bool
    {
        return Str::startsWith($this->mime_type, "text/");
    }

    public function isPdf(): bool
    {
        return $this->mime_type == "application/pdf";
    }

    public function isImage(): bool
    {
        return Str::startsWith($this->mime_type, "image/");
    }

    public function isHtml(): bool
    {
        return $this->mime_type == "text/html";
    }
}
