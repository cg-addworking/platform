<?php

namespace Components\Connector\Airtable\Application\Providers;

use Components\Connector\Airtable\Application\Commands\CreateSogetrelAttachmentCommand;
use Components\Connector\Airtable\Application\Commands\ExtractDataFromSogetrelAttachmentFileCommand;
use Illuminate\Support\ServiceProvider;

class AirtableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateSogetrelAttachmentCommand::class,
                ExtractDataFromSogetrelAttachmentFileCommand::class,
            ]);
        }
    }
}
