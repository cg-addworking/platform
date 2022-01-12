<?php

namespace App\Mail;

use App\Repositories\Sogetrel\Enterprise\SogetrelEnterpriseRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PassworksSearchNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $passworks;
    public $schedule;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($passworks, $schedule)
    {
        $this->passworks = $passworks;
        $this->schedule = $schedule;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $sogetrel = app(SogetrelEnterpriseRepository::class)->getSogetrelEnterprise();

        return $this
            ->subject("Résultat de votre recherche de passwork")
            ->markdown('emails.sogetrel.passwork.search.notification')
            ->with([
                'passworks' => $this->passworks,
                'schedule'  => $this->schedule,
                'url'       => domain_route(route('sogetrel.passwork.index'), $sogetrel)
            ]);
    }
}
