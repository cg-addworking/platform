<?php

namespace App\Contracts\Events;

use App\Models\Addworking\Common\File;

interface DocumentAwareEvent
{
    public function getDocument(): File;

    public function setDocument(File $document);
}
