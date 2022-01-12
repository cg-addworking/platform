<?php

namespace App\Mail;

use App\Models\Addworking\Mission\Proposal;
use App\Repositories\Sogetrel\Enterprise\SogetrelEnterpriseRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationBpu extends Mailable
{
    use Queueable, SerializesModels;

    protected $proposal;

    public function __construct(Proposal $proposal)
    {
        $this->proposal = $proposal;
    }

    public function build()
    {
        $sogetrel = app(SogetrelEnterpriseRepository::class)->getSogetrelEnterprise();

        return $this->subject('Ajout de BPU')
            ->markdown('emails.sogetrel.mission.confirmation_bpu')
            ->attachData($this->proposal->file->path, basename($this->proposal->file->path), [
                    'mime' => 'application/pdf',
                ])
            ->with([
                'proposal' => $this->proposal,
                'url' => domain_route($this->proposal->routes->show, $sogetrel)
            ]);
    }
}
