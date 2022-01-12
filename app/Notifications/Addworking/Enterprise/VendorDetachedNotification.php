<?php

namespace App\Notifications\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorDetachedNotification extends Notification
{
    use Queueable;

    public $vendor;
    public $user;
    public $customer;

    public function __construct(Enterprise $vendor, User $user, Enterprise $customer)
    {
        $this->vendor    = $vendor;
        $this->user      = $user;
        $this->customer  = $customer;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("{$this->vendor->name} a été déréférencé de {$this->customer->name}")
            ->markdown('emails.addworking.enterprise.vendor.detached', [
                'vendor' => $this->vendor,
                'user' => $this->user,
                'customer' => $this->customer,
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'vendor_name'   => $this->vendor->name,
            'user_name' => $this->user->name,
            'customer_name'   => $this->customer->name,
        ];
    }
}
