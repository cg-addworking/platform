<?php

namespace App\Providers\Soprema\Enterprise;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class EnterpriseRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers\Soprema\Enterprise';

    public function map()
    {
        // @todo put this in a trait!
        foreach (get_class_methods(self::class) as $method) {
            if (preg_match('/^map/', $method) && $method !== 'map') {
                $this->$method();
            }
        }
    }

    public function mapCovid19FormAnswer()
    {
        Route::middleware(['web'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('covid19/create', [
                    'uses' => "Covid19FormAnswerController@create",
                    'as'   => "soprema.enterprise.covid19_form_answer.create",
                ]);

                Route::get('covid19/login', [
                    'uses' => "Covid19FormAnswerController@login",
                    'as'   => "soprema.enterprise.covid19_form_answer.login",
                ]);

                Route::post('covid19', [
                    'uses' => "Covid19FormAnswerController@store",
                    'as'   => "soprema.enterprise.covid19_form_answer.store",
                ]);

                Route::get('covid19/confirmation', [
                    'uses' => "Covid19FormAnswerController@confirm",
                    'as'   => "soprema.enterprise.covid19_form_answer.confirm",
                ]);
            });

        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('covid19', [
                    'uses' => "Covid19FormAnswerController@index",
                    'as'   => "soprema.enterprise.covid19_form_answer.index",
                ]);

                Route::get('covid19/{covid19_form_answer}', [
                    'uses' => "Covid19FormAnswerController@show",
                    'as'   => "soprema.enterprise.covid19_form_answer.show",
                ]);

                Route::get('covid19/{covid19_form_answer}/edit', [
                    'uses' => "Covid19FormAnswerController@edit",
                    'as'   => "soprema.enterprise.covid19_form_answer.edit",
                ]);

                Route::put('covid19/{covid19_form_answer}', [
                    'uses' => "Covid19FormAnswerController@update",
                    'as'   => "soprema.enterprise.covid19_form_answer.update",
                ]);

                Route::delete('covid19/{covid19_form_answer}', [
                    'uses' => "Covid19FormAnswerController@destroy",
                    'as'   => "soprema.enterprise.covid19_form_answer.destroy",
                ]);
            });
    }
}
