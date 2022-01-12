<?php

namespace Components\Enterprise\Export\Application\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnterpriseCsvExportMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function build()
    {
        return $this->subject("Exports CSV des informations d'entreprises")
            ->markdown('export::emails.export')
            ->attach($this->path);
    }
}
