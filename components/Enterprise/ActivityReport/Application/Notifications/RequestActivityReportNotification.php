<?php

namespace Components\Enterprise\ActivityReport\Application\Notifications;

use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestActivityReportNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $vendor;
    private $customer;
    private $date;

    public function __construct(Enterprise $vendor, Enterprise $customer, DateTime $date)
    {
        $this->vendor = $vendor;
        $this->customer = $customer;
        $this->date = $date;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $year = $this->date->year;
        $month = strtolower(Carbon::now()->setMonth($this->date->month)->format('F'));

        $translation = 'components.enterprise.activity_report.application.views.activity_report.months.';

        return (new MailMessage)
            ->subject(
                "Votre suivi d’activité - " . __($translation . $month) . " " . $year
            )->markdown('activity_report::emails.request', [
                'vendor' => $this->vendor,
                'url'    => domain_route(
                    route('addworking.enterprise.activity_report.create', [
                        $this->vendor,
                        'year' => $this->date->year,
                        'month'=> $this->date->month,
                    ]),
                    $this->customer
                ),
                'year' => $year,
                'month' => $month,
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'vendor' => $this->vendor->name,
            'url'    => domain_route(
                route('addworking.enterprise.activity_report.create', $this->vendor),
                $this->customer
            ),
        ];
    }
}
