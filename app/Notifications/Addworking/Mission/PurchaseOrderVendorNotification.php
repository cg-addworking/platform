<?php

namespace App\Notifications\Addworking\Mission;

use App\Models\Addworking\Mission\PurchaseOrder;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PurchaseOrderVendorNotification extends Notification
{
    use Queueable;

    protected $purchaseOrder;

    public function __construct(PurchaseOrder $purchaseOrder)
    {
        $this->purchaseOrder = $purchaseOrder;
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
        $pdfName = "bon-de-commande-{$this->purchaseOrder->mission->number}_" .
            Carbon::parse($this->purchaseOrder->created_at)->format('d-m-Y') .
            ".pdf";

        return (new MailMessage)
            ->subject("Nouveau bon de commande pour {$this->purchaseOrder->mission->label}")
            ->markdown('emails.addworking.mission.purchase_order.send_to_vendor', [
                'purchase_order' => $this->purchaseOrder,
                'url' => domain_route($this->purchaseOrder->routes->show, $this->purchaseOrder->mission->customer)
            ])->attachData($this->purchaseOrder->file->content, $pdfName, [
                'mime' => 'application/pdf',
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
            'purchase_order_url' => $this->purchaseOrder->routes->show,
            'mission_name'       => $this->purchaseOrder->mission->label,
            'customer'           => $this->purchaseOrder->mission->customer->name,
        ];
    }
}
