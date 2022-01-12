<?php

namespace Components\Common\WYSIWYG\Application\Providers;

use Components\Common\WYSIWYG\Application\Repositories\WysiwygRepository;
use Components\Common\WYSIWYG\Domain\Interfaces\Repositories\WysiwygRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class WysiwygServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->bindRepositoryInterfaces();
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            WysiwygRepositoryInterface::class,
            WysiwygRepository::class
        );
    }
}
