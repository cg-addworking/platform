<?php

namespace App\Repositories\Addworking\Common;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Common\Comment;
use App\Models\Addworking\User\User;
use App\Repositories\BaseRepository;
use Components\Contract\Contract\Application\Models\Contract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use RuntimeException;
use Illuminate\Support\Facades\Auth;
use Components\Contract\Contract\Application\Repositories\CommentRepository as ContractCommentRepository;

class CommentRepository extends BaseRepository
{
    protected $model = Comment::class;

    /**
     * @todo create and use the Commentable interface
     */
    public function comment(
        Model $commentable,
        string $content,
        string $visibility = Comment::VISIBILITY_PRIVATE,
        User $author = null
    ) {
        if (is_null($author) && ! $author = Auth::user()) {
            throw new RuntimeException("a comment must have an author");
        }

        $comment = new Comment(@compact('content', 'visibility'));
        $comment->commentable()->associate($commentable);
        $comment->author()->associate($author);
        $comment->save();

        return $comment;
    }

    /**
     * @todo v0.38.5 remove $prefix
     */
    public function createFromRequest(Request $request, $prefix = null): Comment
    {
        $data = Arr::wrap($request->input('comment', []));

        if (! is_null($prefix)) {
            $data['content'] = sprintf("%s : %s", $prefix, Arr::get($data, 'content', ''));
        }

        return $this->comment(
            $this->getCommentable($data),
            Arr::get($data, 'content'),
            Arr::get($data, 'visibility', Comment::VISIBILITY_PRIVATE),
            $request->user()
        );
    }

    protected function getCommentable(array $data): Model
    {
        $type = Arr::get($data, 'commentable_type');

        if (is_null($type = Config::get("commentable.allowed.{$type}"))) {
            throw new RuntimeException('The Model is not commentable');
        }

        return $type::findOrFail($data['commentable_id'] ?? null);
    }

    public function notifyUsers(array $ids, Comment $comment)
    {
        $type = $comment->commentable_type;
        $item = $type::find($comment->commentable_id);

        if ($item instanceof Contract) {
            App::make(ContractCommentRepository::class)->notifyUsers($ids, $comment, $item);
        }
    }

    public function getContractSignatories(Contract $contract)
    {
        $signatories = new Collection;
        $contract->getParties()->map(function ($party) use ($signatories) {
            $signatories->push($party->getSignatory());
        });

        return $signatories;
    }
}
