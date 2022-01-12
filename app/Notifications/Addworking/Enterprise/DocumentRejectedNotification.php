<?php

namespace App\Notifications\Addworking\Enterprise;

use App\Models\Addworking\Common\Comment;
use App\Models\Addworking\Enterprise\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentRejectedNotification extends Notification
{
    use Queueable;

    protected $document;
    protected $comment;

    public function __construct(Document $document, Comment $comment = null)
    {
        $this->document = $document;
        $this->comment  = $comment;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Conformité AddWorking : vous avez un document refusé")
            ->markdown('emails.addworking.enterprise.document.rejected', [
                'document' => $this->document,
                'comment'  => $this->comment,
                'url'      => domain_route($this->document->routes->show, $this->document->documentType->enterprise)
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'enterprise_name' => $this->document->enterprise->name,
            'document_type'   => $this->document->documentType->type,
            'document_url'    => $this->document->routes->show,
        ];
    }
}
