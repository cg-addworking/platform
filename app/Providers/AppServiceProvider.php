<?php

namespace App\Providers;

use App\Repositories\RepositoryManager;
use App\Support\Token\InvitationTokenManager;
use Carbon\Carbon;
use Doctrine\DBAL\Driver\PDOException;
use Illuminate\Pagination\Paginator;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class AppServiceProvider extends ServiceProvider
{
    public function boot(UrlGenerator $url)
    {
        if (env('REDIRECT_HTTPS')) {
            $url->forceScheme('https');
        }

        $this
            ->bootDatabase()
            ->bootBlade()
            ->bootValidator()
            ->bootLoggingJobQueue();

        Paginator::useBootstrap();
    }

    public function register()
    {
        $this->app->singleton(InvitationTokenManager::class, function ($app) {
            return new InvitationTokenManager(
                Config::get('invitation.jwt'),
                Config::get('invitation.content')
            );
        });

        $this->app->singleton('repository', function ($app) {
            return new RepositoryManager($app);
        });
    }

    protected function bootDatabase(): self
    {
        foreach (config('database.connections') as $name => $config) {
            if ($config['driver'] == "sqlite") {
                $this->bootSqliteDatabase($name);
            }
        }

        return $this;
    }

    protected function bootSqliteDatabase(string $name): void
    {
        try {
            DB::connection($name)->getPdo()->exec('PRAGMA foreign_keys = ON');
        } catch (InvalidArgumentException $e) {
            // Unable to find database (Heroku won't craeate it)
        } catch (PDOException $e) {
            // Could not find driver (Heroku didn't install it)
        }
    }

    protected function bootBlade(): self
    {
        Blade::directive('date', function ($expression) {
            return (string)'<?php echo ('.$expression.' instanceof DateTime) ? 
                "<span>".('.$expression.')->format(\'d/m/Y\')."</span>" :
                "<span><small class=\"text-muted\">n/a</small></span>"; ?>';
        });

        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression instanceof DateTime) ? ($expression)->format('d/m/Y H:i:s') : 'n/a'; ?>";
        });

        Blade::directive('money', function ($expression) {
            return "<?php echo number_format($expression, 2, '.', ' ') . ' €'; ?>";
        });

        Blade::directive('percentage', function ($expression) {
            return "<?php echo sprintf('%.2f', $expression * 100) ?> %";
        });

        Blade::directive('slug', function ($expression) {
            return "<?php echo str_slug($expression) ?>";
        });

        Blade::directive('tooltip', function ($expression) {
            return "<?php echo attr(['data-toggle' => 'tooltip', 'title' => $expression]) ?>";
        });

        Blade::directive('bool', function ($expression) {
            return "<?php echo \$__env->make('_boolean', ['var' => {$expression}]".
                " + \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>";
        });

        Blade::directive('admin', function ($expression) {
            return '<?php if (Auth::check() && Auth::user()->isSupport()): ?>';
        });

        Blade::directive('endadmin', function ($expression) {
            return '<?php endif ?>';
        });

        Blade::directive('support', function ($expression) {
            return '<?php if (Auth::check() && Auth::user()->isSupport()): ?>';
        });

        Blade::directive('endsupport', function ($expression) {
            return '<?php endif ?>';
        });

        Blade::directive('customer', function ($expression) {
            return '<?php if (Auth::check() && Auth::user()->enterprise->isCustomer()): ?>';
        });

        Blade::directive('endcustomer', function ($expression) {
            return '<?php endif ?>';
        });

        Blade::directive('vendor', function ($expression) {
            return '<?php if (Auth::check() && Auth::user()->enterprise->isVendor()): ?>';
        });

        Blade::directive('endvendor', function ($expression) {
            return '<?php endif ?>';
        });

        Blade::directive('th', function ($expression) {
            return "<?php \$__env->startComponent(".
                "'foundation::layout.app._table_head_cell', ".
                "pipe_to_array({$expression})); ".
                "echo \$__env->renderComponent(); ?>";
        });

        Blade::directive('link', function ($expression) {
            return "<?php \$__env->startComponent('foundation::layout.app._link', ['model' => {$expression}]); ".
                "echo \$__env->renderComponent(); ?>";
        });

        Blade::directive('actions', function ($expression) {
            return "<?php \$__env->startComponent('foundation::layout.app._actions', ['model' => {$expression}]); ".
                "echo \$__env->renderComponent(); ?>";
        });

        Blade::directive('action_item', function ($expression) {
            return "<?php \$__env->startComponent(".
                "'foundation::layout.app._action_item', ".
                "pipe_to_array({$expression})); ".
                "echo \$__env->renderComponent(); ?>";
        });

        Blade::directive('breadcrumb_item', function ($expression) {
            return "<?php \$__env->startComponent('foundation::layout.app._breadcrumb_item', ".
                "pipe_to_array($expression)); echo \$__env->renderComponent(); ?>";
        });

        Blade::directive('na', function ($expression) {
            return "<?php echo \$__env->make('foundation::layout.app._na'); ?>";
        });

        Blade::directive('valorna', function ($expression) {
            return "<?php echo ($expression) ?: \$__env->make('foundation::layout.app._na'); ?>";
        });

        Blade::directive('pushonce', function ($expression) {
            $domain = explode(':', trim(substr($expression, 1, -1)));
            $push_name = $domain[0];
            $push_sub = $domain[1];
            $isDisplayed = '__pushonce_'.$push_name.'_'.$push_sub;
            return "<?php if(!isset(\$__env->{$isDisplayed})):
                    \$__env->{$isDisplayed} = true; \$__env->startPush('{$push_name}'); ?>";
        });
        Blade::directive('endpushonce', function ($expression) {
            return '<?php $__env->stopPush(); endif; ?>';
        });

        return $this;
    }

    protected function bootValidator(): self
    {
        Validator::extend('french_phone_number', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(0|(00|\+)33)[1-9]\d{8}$/', preg_replace("/(\s+|\.)/", '', $value)) != 0;
        });

        return $this;
    }

    protected function bootLoggingJobQueue(): self
    {
        if (config('logging_app.queue_job')) {
            Queue::before(function (JobProcessing $event) {
                DB::connection('pgsql_log')->table('queue_logs')->insert([
                    'job_id' => $event->job->payload()['uuid'],
                    'job_name' => $event->job->payload()['displayName'],
                    'queue_name' => $event->job->getConnectionName(),
                    'metadata' => json_encode($event->job->payload()['data']['command']),
                    'action_type' => 'processing',
                    'exception' => null,
                    'created_at' => Carbon::now(),
                ]);
            });

            Queue::after(function (JobProcessed $event) {
                DB::connection('pgsql_log')->table('queue_logs')->insert([
                    'job_id' => $event->job->payload()['uuid'],
                    'job_name' => $event->job->payload()['displayName'],
                    'queue_name' => $event->job->getConnectionName(),
                    'metadata' => json_encode($event->job->payload()['data']['command']),
                    'action_type' => 'processed',
                    'exception' => null,
                    'created_at' => Carbon::now(),
                ]);
            });

            Queue::failing(function (JobFailed $event) {
                DB::connection('pgsql_log')->table('queue_logs')->insert([
                    'job_id' => $event->job->payload()['uuid'],
                    'job_name' => $event->job->payload()['displayName'],
                    'queue_name' => $event->job->getConnectionName(),
                    'metadata' => json_encode($event->job->payload()['data']['command']),
                    'action_type' => 'failed',
                    'exception' => $event->exception->getMessage(),
                    'created_at' => Carbon::now(),
                ]);
            });
        }

        return $this;
    }
}
