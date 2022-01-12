<?php

namespace App\Models\Addworking\Common;

use App\Helpers\HasUuid;
use App\Models\Addworking\User\User;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection as BaseCollection;
use UnexpectedValueException;

class Comment extends Model implements Htmlable
{
    use SoftDeletes, HasUuid, Viewable, Routable;

    const VISIBILITY_PUBLIC    = 'public';
    const VISIBILITY_PRIVATE   = 'private';
    const VISIBILITY_PROTECTED = 'protected';

    protected $table = 'addworking_common_comments';

    protected $fillable = [
        'content',
        'visibility',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $attributes = [
        'visibility' => self::VISIBILITY_PUBLIC,
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function commentable()
    {
        return $this->morphTo();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id')->withDefault();
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeOfAuthor($query, $author)
    {
        return $query->whereHas('author', function ($query) use ($author) {
            return $query->whereIn('id', $this->parseAuthorIds($author));
        });
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function setVisibilityAttribute($value)
    {
        if (!is_null($value) && !in_array($value, self::getAvailableVisibilities())) {
            throw new UnexpectedValueException("Invalid visibility attribute");
        }

        $this->attributes['visibility'] = $value;
    }

    // ------------------------------------------------------------------------
    // Misc
    // ------------------------------------------------------------------------

    public function newCollection(array $models = [])
    {
        return new CommentCollection($models);
    }

    public static function getAvailableVisibilities()
    {
        return [
            self::VISIBILITY_PROTECTED,
            self::VISIBILITY_PRIVATE,
            self::VISIBILITY_PUBLIC,
        ];
    }

    public function getContentHtmlAttribute()
    {
        return strip_tags(nl2br($this->content), '<br>');
    }

    protected function parseAuthorIds($value): array
    {
        if (is_uuid($value)) {
            return [$value];
        }

        if ($value instanceof Model) {
            return [$value->id];
        }

        if ($value instanceof Collection) {
            return $value->pluck('id')->all();
        }

        if ($value instanceof BaseCollection) {
            return $value->toArray();
        }

        return (array) $value;
    }
}
