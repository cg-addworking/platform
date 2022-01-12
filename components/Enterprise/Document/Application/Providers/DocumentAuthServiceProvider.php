<?php

namespace Components\Enterprise\Document\Application\Providers;

use Components\Enterprise\Document\Application\Models\Document;
use Components\Enterprise\Document\Application\Models\DocumentTypeRejectReason;
use Components\Enterprise\Document\Application\Policies\DocumentPolicy;
use Components\Enterprise\Document\Application\Policies\DocumentTypeRejectReasonPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class DocumentAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        DocumentTypeRejectReason::class => DocumentTypeRejectReasonPolicy::class,
        Document::class => DocumentPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
