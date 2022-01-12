<?php
namespace Components\Infrastructure\PdfManager\Application\Providers;

use Components\Infrastructure\PdfManager\Domain\Classes\PdfManagerInterface;
use Components\Infrastructure\PdfManager\Application\PdfManager;
use Illuminate\Support\ServiceProvider;

class PdfManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->bindPdfManager();
    }

    private function bindPdfManager()
    {
        $this->app->bind(
            PdfManagerInterface::class,
            PdfManager::class,
        );
    }
}
