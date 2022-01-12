<?php

namespace App\Jobs\Addworking\Common\File;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class SendToStorageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $content;

    public function __construct(string $id, $content)
    {
        $this->id = $id;
        $this->content = $content;
    }

    public function handle()
    {
        Storage::disk(Config::get('files.storage.disk'))->put($this->id, $this->content);
    }
}
