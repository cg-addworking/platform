<?php

namespace App\Policies\Addworking\Common;

use App\Models\Addworking\User\User;
use App\Models\Addworking\Common\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;


    public function index(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the comment.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\Models\Addworking\Common\Comment  $comment
     * @return mixed
     */
    public function show(User $user, Comment $comment)
    {
        // || signifie "ou"
        // && signifie "et"
        return $user->isSupport()
            || ($comment->visibility == Comment::VISIBILITY_PRIVATE && $user->is($comment->author))
            || ($comment->visibility == Comment::VISIBILITY_PROTECTED
                && $user->enterprise->users->contains($comment->author))
            || ($comment->visibility == Comment::VISIBILITY_PUBLIC);
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can store comments.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can edit comments.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\Models\Addworking\Common\Comment  $comment
     * @return mixed
     */
    public function edit(User $user, Comment $comment)
    {
        return true;
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\Models\Addworking\Common\Comment  $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\Models\Addworking\Common\Comment  $comment
     * @return mixed
     */
    public function destroy(User $user, Comment $comment)
    {
        return $user->isSupport()
            || $comment->author->is($user);
    }
}
