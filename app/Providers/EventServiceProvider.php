<?php

namespace App\Providers;

use App\Listeners\Addworking\Enterprise\DocumentEventSubscriber;
use App\Listeners\UserEventSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [

        // --------------------------------------------------------------------
        // Users
        // --------------------------------------------------------------------

        \App\Events\UserRegistration::class => [
            \App\Listeners\SetConfirmationToken::class,
            \App\Listeners\SendConfirmationEmail::class,
        ],

        \App\Events\UserConfirmationResend::class => [
            \App\Listeners\SetConfirmationToken::class,
            \App\Listeners\SendConfirmationEmail::class,
        ],

        // --------------------------------------------------------------------
        // Events
        // --------------------------------------------------------------------

        \App\Events\InboundInvoiceSaved::class => [
            \App\Listeners\SendNotificationInboundInvoiceIsPaidEmail::class,
        ],

        \App\Events\DeletingFile::class => [
            \App\Listeners\TrashFile::class,
        ],

        // \App\Events\InvoiceIsValidated::class => [
        //     \App\Listeners\SendNotificationInvoiceIsValidatedEmail::class,
        // ],

        \App\Events\UserCreated::class => [
            \App\Listeners\TagUser::class,
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        UserEventSubscriber::class,
        DocumentEventSubscriber::class,
    ];
}
