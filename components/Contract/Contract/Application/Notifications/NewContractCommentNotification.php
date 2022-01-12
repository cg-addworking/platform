<?php

namespace Components\Contract\Contract\Application\Notifications;

use App\Models\Addworking\Common\Comment;
use Illuminate\Bus\Queueable;
use App\Models\Addworking\User\User;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;

class NewContractCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $comment;
    protected $contract;

    public function __construct(
        User $user,
        Comment $comment,
        ContractEntityInterface $contract
    ) {
        $this->user = $user;
        $this->comment = $comment;
        $this->contract = $contract;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(
                __(
                    'components.contract.contract.application.views.contract.mail.notify_for_new_comment.subject',
                    ['contract_name' => $this->contract->getName()]
                )
            )
            ->markdown('contract::contract.mail.notify_for_new_comment', [
                'contract_name' => $this->contract->getName(),
                'comment_content' => $this->comment->content_html,
                'author_name' => $this->comment->author->name,
                'user_name' => $this->user->name,
                'url' => domain_route(
                    route(
                        'contract.show',
                        $this->contract
                    ),
                    $this->contract->getEnterprise()
                ),
            ]);
    }
}
