<?php

namespace App\Models\Addworking\Common\Concerns\Comment;

use App\Models\Addworking\Common\Comment;
use App\Models\Addworking\User\User;

trait Commentable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commentedBy()
    {
        return $this->hasMany(User::class, 'author_id');
    }
}
