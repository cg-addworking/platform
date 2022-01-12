<?php

namespace App\Notifications\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorNoncomplianceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Enterprise $customer;
    public array $non_compliant_vendors;

    public function __construct(Enterprise $customer, array $non_compliant_vendors)
    {
        $this->customer = $customer;
        $this->non_compliant_vendors = $non_compliant_vendors;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("AddWorking : Prestataires non conformes - ". $this->customer->name)
            ->markdown('emails.addworking.enterprise.vendor.noncompliance', [
                'customer'  => $this->customer,
                'non_compliant_vendors' => $this->non_compliant_vendors,
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'customer'  => $this->customer->name,
            'non_compliant_vendors' => $this->non_compliant_vendors,
        ];
    }
}
