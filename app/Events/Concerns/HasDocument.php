<?php

namespace App\Events\Concerns;

use App\Models\Addworking\Common\File;

trait HasDocument
{
    protected $document;

    public function getDocument(): File
    {
        return $this->document;
    }

    public function setDocument(File $document)
    {
        $this->document = $document;
    }
}
