<?php

namespace Components\Enterprise\DocumentTypeModel\Application\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class DocumentTypeModelRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Enterprise\DocumentTypeModel\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapDocumentTypeModelRoutes();
        $this->mapDocumentTypeModelVariableRoutes();
    }

    private function mapDocumentTypeModelRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "enterprise/{enterprise}/document-type/{document_type}/model";

                Route::get("{$base}/", [
                    'uses' => 'DocumentTypeModelController@index', 'as' => 'document_type_model.index'
                ]);

                Route::get("{$base}/create", [
                    'uses' => 'DocumentTypeModelController@create', 'as' => 'document_type_model.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'DocumentTypeModelController@store', 'as' => 'document_type_model.store'
                ]);

                Route::post("{$base}/preview-wysiwyg", [
                    'uses' => 'DocumentTypeModelController@wysiwygPreview',
                    'as' => 'document_type_model.wysiwyg_preview'
                ]);

                Route::delete("{$base}/{document_type_model}/delete", [
                    'uses' => 'DocumentTypeModelController@delete', 'as' => 'document_type_model.delete'
                ]);

                Route::get("{$base}/{document_type_model}/edit", [
                    'uses' => 'DocumentTypeModelController@edit', 'as' => 'document_type_model.edit'
                ]);

                Route::put("{$base}/{document_type_model}/update", [
                    'uses' => 'DocumentTypeModelController@update', 'as' => 'document_type_model.update'
                ]);

                Route::put("{$base}/{document_type_model}/publish", [
                    'uses' => 'DocumentTypeModelController@publish', 'as' => 'document_type_model.publish'
                ]);

                Route::put("{$base}/{document_type_model}/unpublish", [
                    'uses' => 'DocumentTypeModelController@unpublish', 'as' => 'document_type_model.unpublish'
                ]);
   
                Route::get("{$base}/{document_type_model}", [
                    'uses' => 'DocumentTypeModelController@show', 'as' => 'document_type_model.show'
                ]);
            });
    }

    private function mapDocumentTypeModelVariableRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "enterprise/{enterprise}/document-type/{document_type}/model/{document_type_model}";

                Route::get("{$base}/variable/edit", [
                    'uses' => 'DocumentTypeModelVariableController@edit', 'as' => 'document_type_model.variable.edit'
                ]);

                Route::put("{$base}/variable/update", [
                    'uses' => 'DocumentTypeModelVariableController@update',
                    'as' => 'document_type_model.variable.update'
                ]);
            });
    }
}
