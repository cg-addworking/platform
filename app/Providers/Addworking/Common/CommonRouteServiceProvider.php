<?php

namespace App\Providers\Addworking\Common;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class CommonRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers\Addworking\Common';

    public function map()
    {
        $this->mapFolder();

        Route::middleware(['web', 'auth'])
            ->prefix('addworking')
            ->name('addworking.common.')
            ->namespace($this->namespace)
            ->group(function () {
                Route::resource('enterprise.job', 'JobController');
                Route::resource('enterprise.job.skill', 'SkillController');
                Route::resource('enterprise.passwork', 'PassworkController');

                Route::get('/csv_loader_report/{csv_loader_report}/download', [
                    'uses' => 'CsvLoaderReportController@download',
                    'as'   => 'csv_loader_report.download',
                ]);

                Route::resource('csv_loader_report', 'CsvLoaderReportController');
            });

        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::resource('file', 'FileController');
                Route::get('/file/{file}/ocr-scan', 'FileController@ocrScan')
                    ->name('file.google_vision_read');
                Route::get('/file/{file}/ocr-scan-urssaf', 'FileController@ocrScanUrssaf')
                    ->name('file.google_vision_read_urssaf');
                Route::get('/file/{file}/download', 'FileController@download')->name('file.download');
                Route::get('/file/{file}/iframe', 'FileController@iframe')->name('file.iframe');
            });

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('/file/{file}/logo', 'FileController@logo')->name('file.logo');
            });
    }

    public function mapFolder()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('addworking/enterprise/{enterprise}/folder', [
                    'uses' => "FolderController@index",
                    'as'   => "addworking.common.folder.index",
                ]);

                Route::get('addworking/enterprise/{enterprise}/folder/create', [
                    'uses' => "FolderController@create",
                    'as'   => "addworking.common.folder.create",
                ]);

                Route::get('addworking/enterprise/{enterprise}/folder/attach', [
                    'uses' => "FolderController@attach",
                    'as'   => "addworking.common.folder.attach",
                ]);

                Route::post('addworking/enterprise/{enterprise}/folder/item', [
                    'uses' => "FolderController@link",
                    'as'   => "addworking.common.folder.link",
                ]);

                Route::delete('addworking/enterprise/{enterprise}/folder/{folder}/item/{item}', [
                    'uses' => "FolderController@unlink",
                    'as'   => "addworking.common.folder.unlink",
                ]);

                Route::post('addworking/enterprise/{enterprise}/folder', [
                    'uses' => "FolderController@store",
                    'as'   => "addworking.common.folder.store",
                ]);

                Route::get('addworking/enterprise/{enterprise}/folder/{folder}', [
                    'uses' => "FolderController@show",
                    'as'   => "addworking.common.folder.show",
                ]);

                Route::get('addworking/enterprise/{enterprise}/folder/{folder}/edit', [
                    'uses' => "FolderController@edit",
                    'as'   => "addworking.common.folder.edit",
                ]);

                Route::put('addworking/enterprise/{enterprise}/folder/{folder}', [
                    'uses' => "FolderController@update",
                    'as'   => "addworking.common.folder.update",
                ]);

                Route::delete('addworking/enterprise/{enterprise}/folder/{folder}', [
                    'uses' => "FolderController@destroy",
                    'as'   => "addworking.common.folder.destroy",
                ]);
            });
    }
}
