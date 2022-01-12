<?php

namespace Components\Contract\Contract\Application\Repositories;

use App\Models\Addworking\Common\Comment;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Notifications\NewContractCommentNotification;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\CommentRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;

class CommentRepository implements CommentRepositoryInterface
{
    public function notifyUsers(array $ids, Comment $comment, ContractEntityInterface $contract)
    {
        $users = User::find($ids);

        foreach ($users as $user) {
            Notification::send($user, new NewContractCommentNotification($user, $comment, $contract));
        }
    }
}
