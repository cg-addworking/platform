<?php

namespace App\Mail;

use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\MissionTracking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MissionTrackingCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $mission;

    protected $tracking;

    public function __construct(Mission $mission, MissionTracking $tracking)
    {
        $this->mission = $mission;
        $this->tracking = $tracking;
    }

    public function build()
    {
        return $this
            ->subject("Vous avez un suivi de mission à valider")
            ->markdown('emails.addworking.mission.mission_tracking.created')
            ->with([
                'mission' => $this->mission,
                'tracking' => $this->tracking,
                'url' => domain_route($this->tracking->routes->show, $this->mission->customer)
            ]);
    }
}
