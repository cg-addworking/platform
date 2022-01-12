<?php

namespace Components\Enterprise\DocumentTypeModel\Application\Providers;

use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Application\Policies\DocumentTypeModelPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class DocumentTypeModelAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        DocumentTypeModel::class => DocumentTypeModelPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
