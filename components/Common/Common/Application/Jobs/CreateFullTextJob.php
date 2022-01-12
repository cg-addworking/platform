<?php

namespace Components\Common\Common\Application\Jobs;

use Components\Common\Common\Domain\Interfaces\FileImmutableInterface;
use Components\Common\Common\Domain\UseCases\CreateFullText;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class CreateFullTextJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $file;

    public function __construct(FileImmutableInterface $file)
    {
        $this->file = $file;
    }

    public function handle()
    {
        if (! $this->shouldRun()) {
            return;
        }

        App::make(CreateFullText::class)->handle($this->file);
    }

    protected function shouldRun()
    {
        if ($this->file->hasParent()) {
            return false;
        }

        $full_text_children = $this->file
            ->getChildren()
            ->filter(fn($f) => $f->getMimeType() == 'text/plain');

        if ($full_text_children->count() > 0) {
            return false;
        }

        return true;
    }
}
