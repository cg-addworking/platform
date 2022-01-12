<?php

namespace Components\Billing\PaymentOrder\Application\Notifications;

use App\Models\Addworking\Billing\InboundInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MarkInboundInvoiceAsPaidNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $invoice;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(InboundInvoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Votre facture {$this->invoice->number} a été payée !")
            ->markdown('payment_order::email.inbound_invoice_paid', [
                'invoice' => $this->invoice,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
