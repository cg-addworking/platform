<?php

namespace App\Listeners\Addworking\Enterprise;

use App\Events\Addworking\Enterprise\Document\DocumentCreated;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Config;

class DocumentEventSubscriber
{
    public function onDocumentCreated(DocumentCreated $event)
    {
        $model = $event->document;

        if (Config::get('documents.storage.enabled', false)) {
            $model->sendToStorage();
        }
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            DocumentCreated::class,
            DocumentEventSubscriber::class . '@onDocumentCreated'
        );
    }
}
