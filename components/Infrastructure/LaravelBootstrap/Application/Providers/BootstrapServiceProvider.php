<?php

namespace Components\Infrastructure\LaravelBootstrap\Application\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * Components available through @name shorthands
     *
     * @var array
     */
    protected $components = [
        'anchor'                     => "anchor",
        'attribute'                  => "attribute",
        'button'                     => "button",
        'dropdown'                   => "dropdown",
        'form'                       => "form",
        'form.control'               => "form_control",
        'form.control.checkbox'      => "form_control_checkbox",
        'form.control.checkbox_list' => "form_control_checkbox_list",
        'form.control.input'         => "form_control_input",
        'form.control.label'         => "form_control_label",
        'form.control.radio'         => "form_control_radio",
        'form.control.radio_list'    => "form_control_radio_list",
        'form.control.select'        => "form_control_select",
        'form.control.switch'        => "form_control_switch",
        'form.control.textarea'      => "form_control_textarea",
        'form.group'                 => "form_group",
        'icon'                       => "icon",
        'uuid'                       => "uuid",
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        require_once __DIR__ . '/../helpers/all.php';

        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->loadViewsFrom([
            __DIR__ . '/../components',
            __DIR__ . '/../layouts'
        ], 'bootstrap');

        $this->bootDirectives();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['bootstrap'];
    }

    /**
     * Registers the blade directives.
     *
     * @return void
     */
    protected function bootDirectives()
    {
        Blade::directive('attr', function ($expression) {
            return "<?php echo attr({$expression}, get_defined_vars()) ?>";
        });

        Blade::directive('bool', $bool = function ($expression) {
            return "<?php \$__env->startComponent(".
                "'bootstrap::boolean', ".
                "['value' => {$expression}]); ".
                "echo \$__env->renderComponent(); ?>";
        });

        Blade::directive('boolean', $bool);

        foreach ($this->components as $component => $name) {
            Blade::directive($name, function ($expression) use ($component) {
                return "<?php \$__env->startComponent(".
                    "'bootstrap::{$component}', ".
                    "pipe_to_array({$expression})); ".
                    "echo \$__env->renderComponent(); ?>";
            });
        }
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing assets.
        $this->publishes([

            base_path(
                'vendor/twbs/bootstrap/dist/css/bootstrap.min.css'
            ) => public_path(
                'vendor/addworking/bootstrap/bootstrap.min.css'
            ),

            base_path(
                'vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js'
            ) => public_path(
                'vendor/addworking/bootstrap/bootstrap.bundle.min.js'
            ),

            base_path(
                'vendor/components/jquery/jquery.min.js'
            ) => public_path(
                'vendor/addworking/bootstrap/jquery.min.js'
            ),

            base_path(
                'vendor/components/font-awesome/css/all.min.css'
            ) => public_path(
                'vendor/addworking/bootstrap/font-awesome.min.css'
            ),

            base_path(
                'vendor/components/font-awesome/webfonts'
            ) => public_path(
                'vendor/addworking/webfonts'
            ),

            base_path(
                'vendor/addworking/laravel-bootstrap/components'
            ) => resource_path(
                'views/vendor/addworking/bootstrap/components'
            ),

            base_path(
                'vendor/addworking/laravel-bootstrap/layouts'
            ) => resource_path(
                'views/vendor/addworking/bootstrap/layouts'
            ),

            base_path(
                'vendor/snapappointments/bootstrap-select/dist/css/bootstrap-select.min.css'
            ) => public_path(
                'vendor/addworking/bootstrap/bootstrap-select.min.css'
            ),

            base_path(
                'vendor/snapappointments/bootstrap-select/dist/js/bootstrap-select.min.js'
            ) => public_path(
                'vendor/addworking/bootstrap/bootstrap-select.min.js'
            ),

            base_path(
                'vendor/snapappointments/bootstrap-select/dist/js/i18n'
            ) => public_path(
                'vendor/addworking/bootstrap/bootstrap-select-i18n'
            ),

        ], 'bootstrap');
    }
}
