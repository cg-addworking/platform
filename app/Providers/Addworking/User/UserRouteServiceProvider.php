<?php

namespace App\Providers\Addworking\User;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class UserRouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers\Addworking\User';

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/addworking/user/guest.php'));

        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/addworking/user/auth.php'));

        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('/log/user', [
                    'uses' => 'UserLogController@index',
                    'as'   => 'log.user.index',
                ]);

                Route::get('/log/user/export', [
                    'uses' => 'UserLogController@export',
                    'as'   => 'log.user.export',
                ]);

                Route::get('/addworking/user/{user}/swap/{enterprise}', [
                    'uses' => 'UserController@swapEnterprise',
                    'as'   => 'addworking.user.user.swap_enterprise',
                ]);

                $this->mapTagSoconnext();

                Route::patch('user/{user}/activate', [
                    'uses' => 'UserController@activate',
                    'as'   => 'user.activate',
                ]);
                Route::patch('user/{user}/deactivate', [
                    'uses' => 'UserController@deactivate',
                    'as'   => 'user.deactivate',
                ]);
            });

        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('user/', [
                    'uses' => 'UserController@index',
                    'as'   => 'user.index',
                ]);
                Route::get('user/create', [
                    'uses' => 'UserController@create',
                    'as'   => 'user.create',
                ]);
                Route::post('user/store', [
                    'uses' => 'UserController@store',
                    'as'   => 'user.store',
                ]);
                Route::get('user/{user}', [
                    'uses' => 'UserController@show',
                    'as'   => 'user.show',
                ]);
                Route::get('user/{user}/edit', [
                    'uses' => 'UserController@edit',
                    'as'   => 'user.edit',
                ]);
                Route::put('user/{user}/update', [
                    'uses' => 'UserController@update',
                    'as'   => 'user.update',
                ]);
                Route::delete('user/{user}/destroy', [
                    'uses' => 'UserController@destroy',
                    'as'   => 'user.destroy',
                ]);
                Route::get('user/ajax/exists', [
                    'uses' => 'UserController@ajaxExists',
                    'as'   => 'user.ajax.exists',
                ]);
            });
    }

    public function mapTagSoconnext()
    {
        Route::get('/user/{user}/add-tag-soconnext', 'UserController@addTagSoconnext')
            ->name('user.add_tag_soconnext');

        Route::get('/user/{user}/remove-tag-soconnext', 'UserController@removeTagSoconnext')
            ->name('user.remove_tag_soconnext');
    }
}
