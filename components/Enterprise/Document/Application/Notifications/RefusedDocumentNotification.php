<?php

namespace Components\Enterprise\Document\Application\Notifications;

use App\Models\Addworking\Common\Comment;
use Illuminate\Bus\Queueable;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentEntityInterface;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RefusedDocumentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $document;
    protected $comment;

    public function __construct(DocumentEntityInterface $document, Comment $comment)
    {
        $this->document = $document;
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('document::document_model.refused_document.subject'))
            ->markdown('document::document_model.mail.refused_document', [
                'document_name' => $this->document->getDocumentType()->getName(),
                'document_signatory' => $this->document->getSignedBy()->name,
                'comment' => $this->comment->content_html,
                'url' => domain_route(
                    route(
                        'addworking.enterprise.document.show_trashed',
                        [
                            $this->document->getEnterprise(),
                            $this->document,
                        ]
                    ),
                    $this->document->getEnterprise()
                ),
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
