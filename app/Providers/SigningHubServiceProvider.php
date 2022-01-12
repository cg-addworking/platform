<?php

namespace App\Providers;

use App\Domain\SigningHub\Client as SigningHubClient;
use Illuminate\Support\ServiceProvider;

class SigningHubServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('signinghub', function () {
            return new SigningHubClient(
                config('signinghub.auth.client_id'),
                config('signinghub.auth.secret'),
                config('signinghub.auth.username'),
                config('signinghub.auth.password')
            );
        });
    }
}
