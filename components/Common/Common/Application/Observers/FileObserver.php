<?php

namespace Components\Common\Common\Application\Observers;

use Components\Common\Common\Application\Jobs\CreateFullTextJob;
use Components\Common\Common\Domain\Interfaces\FileImmutableInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\App;

class FileObserver
{
    /*public function created(FileImmutableInterface $file)
    {
        if (App::environment('testing')) {
            return;
        }

        if (! $file->hasParent()) {
            CreateFullTextJob::dispatch($file);
        }
    }*/
}
